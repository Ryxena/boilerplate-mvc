<?php
    class Controller {
        public function view($view, $data=[]) {
            require_once "../app/views/" . $view . ".php";
        }
        public function model($model) {
            require_once "../app/views/" . $model . ".php";
            return new $model;
        }
    }
?>