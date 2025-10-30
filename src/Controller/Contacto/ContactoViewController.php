<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/src/Controller/ViewController.php';

final readonly class ContactoViewController extends ViewController{

    public function __construct(){
        parent::__construct("Contacto/Index");
    }

    public function start(): void{
        parent::call("");
    }
}