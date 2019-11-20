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

var_dump($_SESSION['isAdmin']);

$model = new Model(); 
$model->template =  ($_SESSION['isAdmin'])?'views/main.php':'views/admin.php';
$controller = new Controller($model);
$view = new View($controller, $model);
//$view->output();

// Обработка маршрутов
//$controller_name = 'Main';
//$action_name = 'index';    
// if (!isset($_SESSION['isAdmin'])) {
//     $isAdmin = true;
// }

$routes = explode('/', $_SERVER['REQUEST_URI']);
var_dump($routes);
// получаем имя контроллера
// if ( !empty($routes[0]) )
// {	
//     $controller_name = $routes[1];
// }

if ( !empty($routes[1]) )
{
    $action_name = $routes[1];
} else $action_name = 'index';

var_dump($action_name);

switch($action_name){
    case "sort":
        switch($routes[2]){
            case "name":
                //$sortName = !$sortName;       
                //$x = $sortName;
                $x = $_SESSION['sortName'];   
            break;
            case "email":
                //$sortEmail = !$sortEmail;
                //$x = $sortEmail;
                $x = $_SESSION['sortEmail'];
            break;
            case "status":
                //$sortStatus = !$sortStatus;
                //$x = $sortStatus;
                $x = $_SESSION['sortStatus'];
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
                        $controller->add();
                    break;
                    case "sort":
                        switch($routes[3]){
                            case "name":
                                //$sortName = !$sortName;       
                                //$x = $sortName;      
                                $x = $_SESSION['sortName'];          
                            break;
                            case "email":
                                //$sortEmail = !$sortEmail;
                                //$x = $sortEmail;
                                $x = $_SESSION['sortEmail'];
                            break;
                            case "status":                                
                                //$sortStatus = !$sortStatus;
                                //$x = $sortStatus;
                                $x = $_SESSION['sortStatus'];
                            default:
                            $x = "";
                        };
                        $controller->sortAdmin($routes[3], $x);
                    break; 
                    default:
                    $controller->indexAdmin();
                }            
            }
            else $controller->indexAdmin();
        }
        else $controller->index();
    break;
    default:
    $controller->index();
}

// получаем имя экшена
// if ( !empty($routes[1]) )
// {
//     $action_name = $routes[1];
//     //var_dump($action_name);

//     if ($action_name == "sort"){
//         switch($routes[2]){
//             case "name":
//                 $sortName = !$sortName;       
//                 $x = $sortName;                
//             break;
//             case "email":
//                 $sortEmail = !$sortEmail;
//                 $x = $sortEmail;
//             break;
//             case "status":
//                 $sortStatus = !$sortStatus;
//                 $x = $sortStatus;
//             default:
//             $x = "";
//         }
//         //var_dump($routes[2], $x);
//         $controller->{$action_name}($routes[2], $x);
//     }
//     else{
//         if ($action_name == "add") $controller->{$action_name}($routes[2]);
//         if (empty($routes[2])) $controller->{$action_name}();
//     }
    
// }
// else $controller->index();


//echo $view->output();

// $model = $_GET['model'];
// $view = $_GET['view'];
// $controller = $_GET['controller'];
// $action = $_GET['action'];
// if (!(empty($model) || empty($view) || empty($controller) || empty($action))) {
//     $m = new $model();
//     $c = new $controller($m, $action);
//     $v = new $view($m);
//     echo $v->output();
// }
?>