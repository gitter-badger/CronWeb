<?php
        require_once('server/classes/mysql.php');
        $MySQL = new MySQL();
        if(isset($_POST['JobID']) && is_numeric($_POST['JobID'])){
                if($MySQL->RemoveCronjob($_POST['JobID'])){
                        print(json_encode(Array('Error' => False)));
                }else{
                        print(json_encode(Array('Error' => True)));
                }
        }else{
                print(json_encode(Array('Error' => True)));
        }
?>
