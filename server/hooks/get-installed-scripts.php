<?php
    try{
        require_once('server/classes/filesystem.php');
        $FS = new FileSystem();
        print(json_encode(Array('Error' => False, 'Scripts' => $FS->GetScripts(false))));
    }catch(Exception $E){
        print(json_encode(Array('Error' => True)));
    }
?>
