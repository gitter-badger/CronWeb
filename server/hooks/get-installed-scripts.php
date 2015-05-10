<?php
    try{
        $Path = realpath('/home/scheduler/scripts');
        $Objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($Path, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);

        $Scripts = Array();
        foreach($Objects as $Object){
            if(!is_dir($Object->getPathName())){
                if($Object->getFileName()[0] != '.'){
                    $Scripts[] = Array(
                        'PathName' => $Object->getPathName(),
                        'FileName' => $Object->getFileName()
                    );
                }
            };
        }
        print(json_encode(Array('Error' => False, 'Scripts' => $Scripts)));
    }catch(Exception $E){
        print(json_encode(Array('Error' => True)));
    }
?>
