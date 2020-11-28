<?php

namespace Gaia\core\controllers;

use Gaia\core\config\Requests;

class Test{
 
    public function Show(){
        $c = "ciao";
        echo $c;
    }  


    public function post1(Requests $req){ 
        $body = $req->getBody();

        print_r($body);
    
    }
}