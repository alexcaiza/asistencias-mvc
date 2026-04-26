<?php

namespace App\Core;

class Controller {
    public function model($model) {
        $modelClass = "App\\Models\\" . $model;
        return new $modelClass();
    }

    public function view($view, $data = []) {
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die("La vista $view no existe.");
        }
    }

    public function redirect($url) {
        header("Location: " . URL_BASE . "/" . $url);
        exit;
    }
}
