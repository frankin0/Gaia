<?php

/*Controller file to preparing a url and template*/

namespace Gaia\core\controllers;

use Gaia\core\Gaia;
use Gaia\core\config\Template;
use Gaia\core\classes\SystemClass;
use Gaia\core\config\Route_Beta;
use Gaia\core\config\Internal_error;
use Gaia\core\classes\AuthClass;


class Index extends Template{
 
    public function __construct(){
        $this->requireLogin= false;
    }
    
    public function Show(){
        return parent::view('welcome'); 
    }  

}