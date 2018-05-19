<?php

namespace Gaia\core\controllers;

use Gaia\core\classes\Template;

class Index{
 
    public function Show($var){
        return Template::view('welcome', $var); 
    }  


}