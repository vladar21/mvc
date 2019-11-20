<?php
require_once('Model.php');
require_once('View.php');

class Controller
{
    private $model;
    public function __construct($model) {
        $this->model = $model;
        $this->template = 'views/main.php';
    }
    public function sort($name, $type){
        $model = new Model();              
        $model->template = 'views/main.php';   
        $model->_sortTask($name, $type);
        $view = new View($this, $model);
        $view->output();     
    }

    public function index(){
        $model = new Model();
        $model->template = 'views/main.php';
        $controller = new Controller($model);
        $view = new View($controller, $model);
        $view->output();     
    }

    public function add(){ 
        $model = new Model();     
        header("Location: /");  
        $model->template = 'views/main.php';   
        $model->_addTask($_POST['name'], $_POST['email'], $_POST['task']);
        $view = new View($this, $model);
        $view->output();
    }

    public function del($id){
        $model = new Model();        
        $model->template = ($_SESSION['isAdmin'])?'views/admin.php':'views/main.php';
        header("Location: /"); 
        $model->_delTask($id);
        $view = new View($this, $model);
        $view->output();
    }

    public function update($id){
        $model = new Model();        
        $model->template = ($_SESSION['isAdmin'])?'views/admin.php':'views/main.php';
        //header("Location: /"); 
        $model->_updateTask($id, $_POST['name'], $_POST['email'], $_POST['task']);
        $view = new View($this, $model);
        $view->output();
    }

    public function login(){
        $model = new Model();
        $model->template = 'views/login.php';
        $controller = new Controller($model);
        $view = new View($controller, $model);
        $view->output();        
    }

    public function auth(){
        $model = new Model();    
        //header("Location: /");   
        
        $model->_auth($_POST['login'], $_POST['password']);
        $model->template = ($_SESSION['isAdmin'])?'views/admin.php':'views/main.php';   
        $view = new View($this, $model);
        $view->output();       
    }
}
?>