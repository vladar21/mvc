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
        $model->template ='views/main.php';
        $model->_sortTask($name, $type);
        $view = new View($this, $model);        
        $view->output(); 
    }

    public function sortAdmin($name, $type){
        $model = new Model();  
        $model->template = ($_SESSION['isAdmin'])?'views/admin.php':'views/main.php';
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

    public function indexAdmin(){
        $model = new Model();
        $model->template = 'views/admin.php';
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

    public function addAdmin(){ 
        $model = new Model();     
        ($_SESSION['isAdmin'])?header("Location: /admin"):header("Location: /");  
        $model->template = ($_SESSION['isAdmin'])?'views/admin.php':'views/main.php';   
        $model->_addTask($_POST['name'], $_POST['email'], $_POST['task']);

        $view = new View($this, $model);
        $view->output();
    }

    public function del($id){
        $model = new Model();   
        header("Location: /admin");      
        $model->template = 'views/admin.php';        
        $model->_delTask($id);
        $view = new View($this, $model);
        $view->output();
    }

    public function update($id){
        $model = new Model();        
        header("Location: /admin"); 
        $model->template = 'views/admin.php';     
        // var_dump("status = ".$_POST['status']);   
        $model->_updateTask($id);
        $view = new View($this, $model);
        $view->output();
    }

    public function login(){
        $model = new Model();
        //header("Location: /"); 
        $model->template = 'views/login.php';
        $controller = new Controller($model);
        $view = new View($controller, $model);
        $view->output();        
    }

    public function auth(){
        $model = new Model(); 
        $model->_auth($_POST['login'], $_POST['password']);
        ($_SESSION['isAdmin'])?header("Location: /admin"):header("Location: /");
        $model->template = ($_SESSION['isAdmin'])?'views/admin.php':'views/main.php';   
        $view = new View($this, $model);
        $view->output();       
    }

    public function logout(){
        $_SESSION['isAdmin'] = false;
        $model = new Model();
        header("Location: /");
        $model->template = 'views/main.php';
        $controller = new Controller($model);
        $view = new View($controller, $model);
        $view->output(); 
    }
}
?>