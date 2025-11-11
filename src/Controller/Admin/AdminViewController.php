<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/src/Controller/ViewController.php';

final readonly class AdminViewController extends ViewController{


    public function __construct(){
        parent::__construct("Admin/admin");
    }

    public function start(): void{
        parent::call("");
    }
}