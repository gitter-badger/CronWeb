<?php    
    require_once('server/classes/mysql.php');
    $MySQL = new MySQL();
    $Enabled_BDD = $MySQL->GetEnabledJobs();

	require_once('server/classes/crontab.php');
	$Cron = new Crontab();
	$Enabled_Sys = $Cron->ListJobs();

    if(count($Enabled_BDD) == count($Enabled_Sys) && isset($_POST['JobPos']) && is_numeric($_POST['JobPos'])){
        $JobBDD = $Enabled_BDD[$_POST['JobPos']];
        $JobSys = $Enabled_Sys[$_POST['JobPos']];

        $JobBDD = Array($JobBDD['JOB_MIN'], $JobBDD['JOB_HOUR'], $JobBDD['JOB_DOM'], $JobBDD['JOB_MON'], $JobBDD['JOB_DOW'], $JobBDD['JOB_CMD']);

        $JobSys = explode(' ', $JobSys);
        $Tmp = implode(' ', array_splice($JobSys, 5));
        $JobSys[5] = $Tmp;

        if(count(array_diff($JobBDD, $JobSys)) == 0){
            $ScriptLogsDirname = substr($Enabled_BDD[$_POST['JobPos']]['JOB_CMD'], 0, strrpos($Enabled_BDD[$_POST['JobPos']]['JOB_CMD'], '/')) . '/Logs';
            try{
                $Path = realpath($ScriptLogsDirname);
                $Objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($Path, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);

                $Files = Array();
                foreach($Objects as $Key => $Object){
                    $Files[$Key] = $Object->getPathName();
                }
                rsort($Files);

                require_once('server/classes/filesystem.php');
                $FS = new FileSystem();

                $Contents = Array();
                foreach($Files as $File){
                    if(!is_dir($File)){
                        $Contents[] = $FS->TailCustom($File, 1);
                    };
                }
                print(json_encode(Array('Error' => False, 'NBContents' => count($Contents), 'Contents' => $Contents)));
            }catch(Exception $E){
                print(json_encode(Array('Error' => True)));
            }
        }else{
            print(json_encode(Array('Error' => True)));
        }
    }else{
           print(json_encode(Array('Error' => True))); 
    }
?>
