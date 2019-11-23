<?php
require_once('Model.php');
require_once('View.php');

class Controller
{
    private $model;
    // конструктор контроллера с параметрами
    public function __construct($model) {
        $this->model = $model;
        $this->template = 'views/main.php';
    }
    // пользовательская сортировка
    public function sort($name, $p){    
        $type = ($_SESSION['sortType'] == 'ASC')?'DESC':'ASC';
        $_SESSION['sortType'] = $type;
        $_SESSION['currentPage'] = $p;
        $model = new Model($p, $type, $name);
        
        switch($name){
            case "name":                
                $_SESSION['nameSort'] = 'name';
            break;
            case "email":                
                $_SESSION['nameSort'] = 'email';
            break;
            case "stat":                
                $_SESSION['nameSort'] = 'stat';
            break;
        }     
        $model->template = 'views/main.php';
        $view = new View($this, $model);        
        $view->output();         
    }
    // сортировка под админом
    public function sortAdmin($name, $p){     
        $type = ($_SESSION['sortType'] == 'ASC')?'DESC':'ASC';
        $_SESSION['sortType'] = $type;
        //$page = $this->currpage();
        $_SESSION['currentPage'] = $p;
        $model = new Model($p, $type, $name);
        
        switch($name){
            case "name":                
                $_SESSION['nameSort'] = 'name';
            break;
            case "email":                
                $_SESSION['nameSort'] = 'email';
            break;
            case "stat":                
                $_SESSION['nameSort'] = 'stat';
            break;
        }     
        $model->template = 'views/admin.php';
        $view = new View($this, $model);        
        $view->output(); 
    }
    // вывод служебных сообщений на экран
    public function indexMessage($im){
        $model = new Model($this->currpage(), $this->currtype(), $this->currname());
        $model->template = 'views/main.php';
        $_SESSION['show'] = 1;  
        $model->message($im);
        $controller = new Controller($model);
        $view = new View($controller, $model);
        $view->output();
    }
    // вывод текущей страницы
    public function index($p){  
        $_SESSION['currentPage'] = $p; 
        $_SESSION['start'] = true;     
        $model = new Model($p, $this->currtype(), $this->currname());     
        $model->template = 'views/main.php';
        $controller = new Controller($model);
        $view = new View($controller, $model);
        $view->output();     
    }
    // вывод текущей страницы под админом
    public function indexAdmin($p){
        $_SESSION['currentPage'] = $p; 
        $_SESSION['start'] = true;
        $model = new Model($p, $this->currtype(), $this->currname());
        $model->template = 'views/admin.php';        
        $controller = new Controller($model);
        $view = new View($controller, $model);
        $view->output();     
    }
    // добавляем новую задачу (пользователь)
    public function add($p){   
        $_SESSION['currentPage'] = $p;        
        $model = new Model($p, $this->currtype(), $this->currname());
        header("Location: /");
        $model->template = 'views/main.php';
        $val = $model->validation($_POST['name'], $_POST['email']);
        $_SESSION['show'] = 1;  
        if($val >= 7 && $val <= 10){
            $model->message($val);
        }
        else{
            $model->message(1);                  
            $model->_addTask($_POST['name'], $_POST['email'], $_POST['task']);
        }        
        $view = new View($this, $model);
        $view->output();
    }
    // добавляем новую задачу (админ)
    public function addAdmin(){ 
        $p = $this->currpage();
        $model = new Model($p, $this->currtype(), $this->currname());
        header("Location: /admin");  
        $model->template = 'views/admin.php';
        $val = $model->validation($_POST['name'], $_POST['email']);
        $_SESSION['show'] = 1;  
        if($val >= 7 && $val <= 10){
            $model->message($val);
        }
        else{
            $model->message(1);                  
            $model->_addTask($_POST['name'], $_POST['email'], $_POST['task']);
        }        
        $view = new View($this, $model);
        $view->output();
    }
    // удаляем задачу
    public function del($id){
        $p = $this->currpage();        
        $model = new Model($p, $this->currtype(), $this->currname());   
        if ($model->_delTask($id)) $model->message(2);
            else $model->message(12);
        header("Location: /admin/page/".$p."");
        $model->template = 'views/admin.php';   
        $_SESSION['show'] = 1;              
        $view = new View($this, $model);
        $view->output();
    }
    // вносим изменения в задачу (под админом)
    public function update($id){
        $p = $this->currpage();
        $model = new Model($p, $this->currtype(), $this->currname());
        header("Location: /admin/page/".$p.""); 
        $model->template = 'views/admin.php';
        $_SESSION['show'] = 1;
        $model->message(3);    
        $model->_updateTask($id);
        $view = new View($this, $model);
        $view->output();
    }
    // выводим форму для авторизации 
    public function login(){        
        $model = new Model($this->currpage(), $this->currtype(), $this->currname());
        $model->template = 'views/login.php';        
        $controller = new Controller($model);
        $view = new View($controller, $model);
        $view->output();        
    }
    // авторизация
    public function auth(){
        $model = new Model($this->currpage(), $this->currtype(), $this->currname()); 
        $model->_auth($_POST['login'], $_POST['password']);
        $_SESSION['show'] = 1;
        if ($_SESSION['isAdmin']){
            header("Location: /admin");
            $model->template = 'views/admin.php';
            $model->message(4); 
        }
        else{
            header("Location: /");
            $model->template = 'views/main.php';
            $model->message(5);
        }
        $view = new View($this, $model);
        $view->output();       
    }
    // выход из режима админа
    public function logout(){ 
        $model = new Model($this->currpage(), $this->currtype(), $this->currname());
        header("Location: /");
        $model->logout();
        $model->template = 'views/main.php';
        $_SESSION['show'] = 1;
        $model->message(6); 
        $controller = new Controller($model);
        $view = new View($controller, $model);
        $view->output(); 
    }
    // вспомогательная функция для определения поля для сортировки текущей страницы
    public function currname(){
        if (isset($_SESSION['nameSort']) == false) $n = 'name';
        else $n = $_SESSION['nameSort'];
        return $n;
    } 
    // вспомогательная функция для определения вида сортировки текущей страницы
    public function currtype(){
        if (isset($_SESSION['sortType']) == false) $t = 'ASC';
        else $t = $_SESSION['sortType'];
        return $t;
    }
    // вспомогательная функция для определения номера текущей страницы
    public function currpage(){
        if (isset($_SESSION['currentPage']) == false) $p = 1;
        else $p = $_SESSION['currentPage'];
        return $p;
    }
}
?>