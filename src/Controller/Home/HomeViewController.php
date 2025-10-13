<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/src/Controller/ViewController.php';

final readonly class HomeViewController extends ViewController{


    public function __construct(){
        parent::__construct("Home/home");
    }

    public function start(): void{
        parent::call("");
    }
}