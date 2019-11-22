<?php
session_start();

require_once('Model.php');
require_once('View.php');
require_once('Controller.php');

// устанавливаем начальные флаги для сортировки
if (!isset($_SESSION['sortName'])) {
    $sortName = true;
} 
if (!isset($_SESSION['sortEmail'])) {
    $sortEmail = true;
} 
if (!isset($_SESSION['sortStatus'])) {
    $sortStatus = true;
}

if (isset($_SESSION['isAdmin']) == false) $_SESSION['isAdmin'] = false;

$model = new Model(1); 
$model->template =  ($_SESSION['isAdmin'])?'views/main.php':'views/admin.php';
$controller = new Controller($model);
$view = new View($controller, $model);
//$view->output();


// обработка маршрутов

$routes = explode('/', $_SERVER['REQUEST_URI']);
if ( !empty($routes[1]) )
{
    $action_name = $routes[1];
} else 
{
    $page = 1;
    $action_name = 'index';
}

switch($action_name){
    case "sort":
        switch($routes[2]){
            case "name":
                $x = $_SESSION['sortName'];   
            break;
            case "email":
                $x = $_SESSION['sortEmail'];
            break;
            case "status":
                $x = $_SESSION['sortStatus'];
            break;
            default:
            $x = "";
        };
        $controller->sort($routes[2], $x);
    break;
    case "add":
        $controller->add();
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
                        switch($routes[3]){
                            case "name":     
                                $x = $_SESSION['sortName'];          
                            break;
                            case "email":
                                $x = $_SESSION['sortEmail'];
                            break;
                            case "status":                                
                                $x = $_SESSION['sortStatus'];
                            break;                            
                            default:
                            $x = "";
                        };
                        $controller->sortAdmin($routes[3], $x);
                    break;
                    case "page":
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
        $controller->index($routes[2]);
    break;
    default:
    $controller->index($page);
}

?>