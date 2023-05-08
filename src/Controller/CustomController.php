<?php
namespace Drupal\new_module\Controller;

use Drupal\Core\Controller\ControllerBase;

class CustomController extends ControllerBase{
    public function new(){
        return [
            '#markup'=>'new module !!',
        ];
    }
}