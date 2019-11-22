<?php
class View
{
    private $model;
    private $controller;
    public function __construct($controller,$model) {
        $this->controller = $controller;
        $this->model = $model;
    }
	
    public function output(){
        // return "<p>" . $this->model->db . "</p>";
        $data = $this->model->string;
        $lastPage = $this->model->lastPage;
        $currentPage = $this->model->currentPage;
        require_once($this->model->template);
    }
}