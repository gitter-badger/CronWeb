<?php
    $Error = true;
    
    if(!isset($_POST['Login']) || strlen($_POST['Login']) == 0){
        $ErrorMsg = 'Bad login or password !';
    }elseif(!isset($_POST['Password']) || strlen($_POST['Password']) == 0){
        $ErrorMsg = 'Bad login or password !';
    }else{
        $Error = false;
    }

    if(!$Error) {
        require_once('../classes/mysql.php');
        $MySQL = new MySQL();
        $Connect = $MySQL->GetUserPassword($_POST['Login']);

        if(count($Connect) > 0 && strcmp($Connect[0]['USER_PASSWORD'], md5($_POST['Password'])) == 0){
            session_start();
            $_SESSION['user_name'] = $Connect[0]['USER_NAME'];
            $_SESSION['user_login'] = $Connect[0]['USER_LOGIN'];
            
            $Result = Array('Error' => false);
        }else{
            $Result = Array('Error' => true, 'ErrorMsg' => 'Bad login or password !');
        }
    } else {
        $Result = Array('Error' => True, 'ErrorMsg' => $ErrorMsg);
    }

    print(json_encode($Result));
?>
