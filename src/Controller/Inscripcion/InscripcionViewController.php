<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/src/Controller/ViewController.php';

final readonly class InscripcionViewController extends ViewController{


    public function __construct(){
        parent::__construct("Inscripcion/index");
    }

    public function start(): void{
        parent::call("");
    }
}