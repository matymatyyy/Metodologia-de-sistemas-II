<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/src/Controller/ViewController.php';

final readonly class CarreraViewController extends ViewController{


    public function __construct(){
        parent::__construct("Admin/carreras");
    }

    public function start(): void{
        parent::call("");
    }
}