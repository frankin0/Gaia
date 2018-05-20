<?php

namespace Gaia\core\controllers;

use Gaia\core\config\Template;

class Index{
 
    public function Show($var){
        $c = "ciao";
        return Template::view('welcome', $var); 
    }  

    public $c, $p;

}