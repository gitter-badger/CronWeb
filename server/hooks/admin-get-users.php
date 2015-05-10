<?php
    require_once('../classes/mysql.php');
	$MySQL = new MySQL();
    
    $Users = $MySQL->GetUsers();
    if(count($Users) == 0){
        $Users = Array('NBItems' => 0);
    }else{
        $Users = Array('NBItems' => count($Users), 'Items' => $Users);
    }
	
	print(json_encode($Users));
?>