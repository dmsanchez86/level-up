<?php
class RaintTplConnect{
    private $_tpl;
    public function __construct($path){
         include_once "rain.tpl.class.php"; //include Rain TPL
         array_map( "unlink", glob( raintpl::$cache_dir . "*.rtpl.php" ) );
         raintpl::configure("base_url",null);
         raintpl::configure("tpl_dir", $path);
         raintpl::configure("path_replace",false);  
     }
     public function dibujarPlantilla($name,$assign,$name_l="datosloop"){
        $this->_tpl = new RainTPL();
        $this->_tpl->assign($assign);
        $this->_tpl->draw($name);
    }
}
?>