<?php
        $Error = False;
        if(!isset($_POST['JobID']) || $_POST['JobID'] == '') $Error = True;
        if(!isset($_POST['Minute']) || $_POST['Minute'] == '') $Error = True;
        if(!isset($_POST['Hour']) || $_POST['Hour'] == '') $Error = True;
        if(!isset($_POST['Month']) || $_POST['Month'] == '') $Error = True;
        if(!isset($_POST['DayWeek']) || $_POST['DayWeek'] == '') $Error = True;
        if(!isset($_POST['DayMonth']) || $_POST['DayMonth'] == '') $Error = True;
        if(!isset($_POST['Name']) || $_POST['Name'] == '') $Error = True;
        if(!isset($_POST['Command']) || $_POST['Command'] == '') $Error = True;

        if(!$Error) {
                require_once('server/classes/mysql.php');
                $MySQL = new MySQL();

                $Result = Array('Error' => !$MySQL->EditJob($_POST['JobID'], $_POST['Minute'], $_POST['Hour'], $_POST['DayMonth'], $_POST['Month'], $_POST['DayWeek'], $_POST['Name'], $_POST['Command']));
        } else {
                $Result = Array('Error' => True);
        }

        print(json_encode($Result));
?>
