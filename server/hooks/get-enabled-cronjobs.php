<?php
    $_POST['JobPos'] = 0;
    require_once('server/classes/mysql.php');
    $MySQL = new MySQL();
    $Enabled_BDD = $MySQL->GetEnabledJobs();

    require_once('server/classes/crontab.php');
    $Cron = new Crontab();
    $Enabled_Sys = $Cron->ListJobs();

    $Actives = Array();
    if(count($Enabled_BDD) == count($Enabled_Sys)){
        foreach($Enabled_Sys as $Pos => $JobSys){
            $JobBDD = $Enabled_BDD[$Pos];

            $JobBDD = Array($JobBDD['JOB_MIN'], $JobBDD['JOB_HOUR'], $JobBDD['JOB_DOM'], $JobBDD['JOB_MON'], $JobBDD['JOB_DOW'], $JobBDD['JOB_CMD']);

            $JobSys = explode(' ', $JobSys);
            $Tmp = implode(' ', array_splice($JobSys, 5));
            $JobSys[5] = $Tmp;

            if(count(array_diff($JobBDD, $JobSys)) == 0){
                $ScriptLogsDirname = substr($Enabled_BDD[$_POST['JobPos']]['JOB_CMD'], 0, strrpos($Enabled_BDD[$_POST['JobPos']]['JOB_CMD'], '/')) . '/Logs';
                $ScriptInProgress = substr($Enabled_BDD[$_POST['JobPos']]['JOB_CMD'], 0, strrpos($Enabled_BDD[$_POST['JobPos']]['JOB_CMD'], '.')) . '.run';
                
                if(!file_exists($ScriptInProgress)){
                    $Path = realpath($ScriptLogsDirname);
                    $Objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($Path, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);
    
                    $Files = Array();
                    foreach($Objects as $Key => $Object){
                        $Files[$Key] = $Object->getPathName();
                    }
                    rsort($Files);
                    
                    require_once('server/classes/filesystem.php');
                    $FS = new FileSystem();
                    $Content = $FS->TailCustom($Files[0], 1);

                    if(!empty($Content)){
                        if($Content[0] == '0'){
                            $LastState = 0;
                        }elseif($Content[0] == '1'){
                            $LastState = 1;
                        }else{
                            $LastState = 2;
                        }
                    }else{
                        $LastState = 3;
                    }
                }else{
                    $LastState = 4;
                }
            }else{
                $LastState = 3;
            }
            
            $Actives[] = Array('LastState' => $LastState, 'Job' => $JobSys);
        }
    }

    print(json_encode(Array('NBItems' => count($Actives), 'Items' => $Actives)));
?>
