<?php
    $Error = true;
    
    if(!isset($_POST['UserID']) || $_POST['UserID'] <= 0 || !is_numeric($_POST['UserID'])){
        $ErrorMsg = 'Bad user iD !';
    }elseif(!isset($_POST['Role']) || $_POST['Role'] <= 0 || !is_numeric($_POST['Role'])){
        $ErrorMsg = 'Please select a role !';
    }elseif(!isset($_POST['Login']) || $_POST['Login'] == '' || preg_match('/[\'^£$€%&*()}{@#~?><>,|=_+¬-]/', $_POST['Login'])){
        $ErrorMsg = 'Please enter a valid login (no special chars) !';
    }elseif(!isset($_POST['Username']) || $_POST['Username'] == ''){
        $ErrorMsg = 'Please enter a user name';
    }elseif(strcmp($_POST['Password'], $_POST['PasswordConfirm']) !== 0){
        $ErrorMsg = 'Password should be confirmed !';
    }else{
        $Error = false;
    }

    if(!$Error) {
        require_once('../classes/mysql.php');
        $MySQL = new MySQL();

        $Result = Array('Error' => $MySQL->EditUser($_POST['UserID'], $_POST['Role'], $_POST['Username'], $_POST['Login'], $_POST['Password']));
    } else {
        $Result = Array('Error' => True, 'ErrorMsg' => $ErrorMsg);
    }

    print(json_encode($Result));
?>
