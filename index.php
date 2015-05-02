<?php
        require_once('common/header.php');

        $URI = explode('/', $_GET['p']);

        if(!isset($_GET['p']) || strlen($_GET['p']) == 0){
                require_once('pages/home.php');
        }else{
                if(file_exists(getcwd().'/pages/'.$URI[0])){
                        for($I = 1;$I < count($URI);$I++){
                                $DynVar = explode('=', $URI[$I]);
                                $DynVar[0] = trim(str_replace(' ', '', ucwords($DynVar[0])));
                                if(isset($DynVar[0]) && isset($DynVar[1])){
                                        ${'Dyn_'.$DynVar[0]} = $DynVar[1];
                                }
                        }
                        require_once('pages/' . $URI[0]);
                }else{
                        require_once('common/errors/404.php');
                }
        }

        require_once('common/footer.php');
?>
