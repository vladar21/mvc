<?php
session_start();

require_once('Model.php');
require_once('View.php');
require_once('Controller.php');

// загрузка
if (isset($_SESSION['isAdmin']) == false) $_SESSION['isAdmin'] = false;
if (isset($_SESSION['sortType']) == false) $_SESSION['sortType'] = 'ASC';
if (isset($_SESSION['nameSort']) == false) $_SESSION['nameSort'] = 'name';

if (isset($_SESSION['start']) == false) {
    $model = new Model(1, 'ASC', 'name'); 
    $model->template =  'views/main.php';
    $controller = new Controller($model);
    $view = new View($controller, $model);
}
else{
    if (isset($_SESSION['nameSort']) == false) $n = 'name';
        else $n = $_SESSION['nameSort'];
    
    if (isset($_SESSION['sortType']) == false) $t = 'ASC';
        else $t = $_SESSION['sortType'];
    
    if (isset($_SESSION['currentPage']) == false) $p = 1;
        else $p = $_SESSION['currentPage']; 

    $model = new Model($p, $t, $n); 
    $model->template = ($_SESSION['isAdmin'])?'views/admin.php':'views/main.php';
    $controller = new Controller($model);
    $view = new View($controller, $model);
}

// обработка маршрутов

$routes = explode('/', $_SERVER['REQUEST_URI']);

if ( !empty($routes[1]) ){
    $action_name = $routes[1];    
} else {    
    $action_name = 'index';        
}

$page = (isset($_SESSION['currentPage']) == false)?1:$_SESSION['currentPage'];

switch($action_name){
    case "sort":
        if($routes[2] == "add") $controller->add($page);
            else $controller->sort($routes[2], $page);
    break;
    case "add":
        $controller->add($page);
    break;    
    case "auth":
        $controller->auth();
    break;
    case "logout":
        $controller->logout();
    break;
    case "login":
        $controller->login();
    break;
    case "admin":
        if ($_SESSION['isAdmin']){
            if (isset($routes[2])){
                switch($routes[2]){
                    case "del":
                        $controller->del($routes[3]);
                    break;
                    case "update":
                        $controller->update($routes[3]);        
                    break;
                    case "add":
                        $controller->addAdmin();
                    break;
                    case "sort":
                        if($routes[3] == "add") $controller->addAdmin();
                            else $controller->sortAdmin($routes[3], $page); 
                    break;
                    case "page":
                        if($routes[3] == "add") $controller->addAdmin($page);
                        else {
                            $page = $routes[3];
                            $controller->indexAdmin($page);
                        }
                        $controller->indexAdmin($routes[3]);            
                    break;
                    default:
                    $controller->indexAdmin($page);
                }            
            }
            else $controller->indexAdmin(1);
        }
        else $controller->indexMessage(11);

    break;
    case "page":
        if($routes[2] == "add") $controller->add($page);
        else {
            $page = $routes[2];
            $controller->index($page);
        }
    break;
    default:
    $controller->index($page);
}

?>