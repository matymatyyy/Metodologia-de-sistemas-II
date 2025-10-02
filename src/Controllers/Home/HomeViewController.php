<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/src/Controllers/ViewController.php';

final readonly class AdminLoginViewController extends ViewController{


    public function __construct(){
        parent::__construct("Home");
    }

    public function start(): void{
        parent::call("");
    }
}