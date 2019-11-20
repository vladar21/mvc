<?php
session_start();

require_once('Model.php');
require_once('View.php');
require_once('Controller.php');

// флаги для сортировки
if (!isset($_SESSION['sortName'])) {
    $sortName = true;
} else {
    $sortName = $_SESSION['sortName'];
}
if (!isset($_SESSION['sortEmail'])) {
    $sortEmail = true;
} else {
    $sortEmail = $_SESSION['sortEmail'];
}
if (!isset($_SESSION['sortStatus'])) {
    $sortStatus = true;
} else {
    $sortStatus = $_SESSION['sortStatus'];
}

var_dump($_SESSION['isAdmin']);//////////////////////////

$model = new Model();
$model->template = ($_SESSION['isAdmin'])?'views/admin.php':'views/main.php';
$controller = new Controller($model);
$view = new View($controller, $model);


// Обработка маршрутов
//$controller_name = 'Main';
$action_name = 'index';    
// if (!isset($_SESSION['isAdmin'])) {
//     $isAdmin = true;
// }

var_dump($_SESSION['isAdmin']);//////////////////////////

$routes = explode('/', $_SERVER['REQUEST_URI']);
var_dump($routes);//////////////////////////////////////
// получаем имя контроллера
// if ( !empty($routes[0]) )
// {	
//     $controller_name = $routes[1];
// }

if ( !empty($routes[1]) )
{
    $action_name = $routes[1];
}

var_dump($action_name);/////////////////////////////////

switch($action_name){
    case "sort":
        switch($routes[2]){
            case "name":
                $sortName = !$sortName;       
                $x = $sortName;                
            break;
            case "email":
                $sortEmail = !$sortEmail;
                $x = $sortEmail;
            break;
            case "status":
                $sortStatus = !$sortStatus;
                $x = $sortStatus;
            default:
            $x = "";
        };
        $controller->{$action_name}($routes[2], $x);
    break;
    case "add":
        $controller->{$action_name}();
    break;
    case "del":
        $controller->{$action_name}($routes[2]);        
    break;
    case "update":
        $controller->{$action_name}($routes[2]);        
    break;
    case "auth":
        $controller->{$action_name}();
    break;
    default:
    $controller->{$action_name}();
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