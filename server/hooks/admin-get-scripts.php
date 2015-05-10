<?php
	require_once('../classes/filesystem.php');

	$FS = new FileSystem();

    $Scripts = $FS->GetScripts();
    if(count($Scripts) == 0){
        $Scripts = Array('NBItems' => 0);
    }else{
        $Scripts = Array('NBItems' => count($Scripts), 'Items' => $Scripts);
    }

    print(json_encode($Scripts));
?>
