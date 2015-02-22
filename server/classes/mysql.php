<?php
class MySQL{
        var $DB = null;
        var $DB_HOST = '10.0.0.53';
        var $DB_USER = 'scheduler';
        var $DB_UPWD = 'Mf2k13tJVga1CguNbITc';
        var $DB_NAME = 'scheduler';

        function MySQL(){
                $this->DB = new PDO('mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME . ';charset=utf8', $this->DB_USER, $this->DB_UPWD);
        }

        function GetJob($JobID){
                $Stmt = $this->DB->prepare('SELECT * FROM JOBS WHERE JOB_ID = ?');
                $Stmt->execute(Array($JobID));
                return $Stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function GetAllJobs(){
                $Stmt = $this->DB->query('SELECT * FROM JOBS ORDER BY JOB_ID');
                return $Stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        function GetEnabledJobs(){
                $Stmt = $this->DB->query('SELECT * FROM JOBS WHERE JOB_IS_ENABLED = 1 ORDER BY JOB_ID');
                return $Stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function AddNewJob($JobMin, $JobHour, $JobDom, $JobMon, $JobDow, $JobName, $JobCmd, $JobDirectlyEnabled){
                $JobIsEnabled = 0;
                if($JobDirectlyEnabled == 'Enable'){
                        $JobIsEnabled = 1;
                }

                $Stmt = $this->DB->prepare('INSERT INTO JOBS (JOB_MIN, JOB_HOUR, JOB_DOM, JOB_MON, JOB_DOW, JOB_NAME, JOB_CMD, JOB_IS_ENABLED) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $Stmt->execute(Array($JobMin, $JobHour, $JobDom, $JobMon, $JobDow, $JobName, $JobCmd, $JobIsEnabled));

                if($this->DB->lastInsertId() > 0){
                        return True;
                }else{
                        return False;
                }
        }

        function EditJob($JobID, $JobMin, $JobHour, $JobDom, $JobMon, $JobDow, $JobName, $JobCmd){
                $Stmt = $this->DB->prepare('UPDATE JOBS SET JOB_MIN = ?, JOB_HOUR = ?, JOB_DOM = ?, JOB_MON = ?, JOB_DOW = ?, JOB_NAME = ?, JOB_CMD = ? WHERE JOB_ID = ?');
                if($Stmt->execute(Array($JobMin, $JobHour, $JobDom, $JobMon, $JobDow, $JobName, $JobCmd, $JobID))){
                        return True;
                }else{
                        return False;
                }
        }

        function EnableCronjob($JobID){
                $Stmt = $this->DB->prepare('UPDATE JOBS SET JOB_IS_ENABLED = 1 WHERE JOB_ID = ?');
                if($Stmt->execute(Array($JobID))){
                        return True;
                }
                return False;
        }

        function DisableCronjob($JobID){
                $Stmt = $this->DB->prepare('UPDATE JOBS SET JOB_IS_ENABLED = 0 WHERE JOB_ID = ?');
                if($Stmt->execute(Array($JobID))){
                        return True;
                }
                return False;
        }

        function DisableAllCronjobs(){
                $Stmt = $this->DB->prepare('UPDATE JOBS SET JOB_IS_ENABLED = 0');
                if($Stmt->execute()){
                        return True;
                }
                return False;
        }

        function RemoveCronjob($JobID){
                $Stmt = $this->DB->prepare('DELETE FROM JOBS WHERE JOB_ID = ?');
                if($Stmt->execute(Array($JobID))){
                        return True;
                }
                return False;
        }

        function RemoveAllJobs(){
                if($this->DB->query('TRUNCATE TABLE JOBS')){
                        return True;
                }
                return False;
        }
}
?>
