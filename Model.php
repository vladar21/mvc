<?php

class Model
{
    public $string;
    public function __construct(){        
        $db = $this->loadDB();
        $this->string = $db->query('SELECT * FROM tasks')->fetchAll();
        $this->template = 'views/main.php';
    }

    public function loadDB(){
        $db = new PDO('sqlite:./mysqlite.sqlite');
        $db->exec('CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY, name TEXT NOT NULL, 
            email TEXT NOT NULL, task TEXT NOT NULL, status TEXT NOT NULL)');
        
        return $db;
    }
    // защита
    public function test_input($data) {
        // удаляем ненужные символы (лишний пробел, табуляцию, символ новой строки)
        $data = trim($data);
        // убираем обратную косую черту
        $data = stripslashes($data);
        // экранируем html код
        $data = htmlspecialchars($data);
        return $data;
    }
    // авторизация
    public function _auth($login, $password){
        var_dump("Auth: ".$login." ".$password);//////////////////////////////

        $db = new PDO('sqlite:./mysqlite.sqlite');
        $db->exec("CREATE TABLE IF NOT EXISTS admins (
            id INTEGER PRIMARY KEY, login TEXT NOT NULL, password TEXT NOT NULL);");
        
        $admins = $db->query("SELECT * FROM admins")->fetchAll();
        if (count($admins) == 0) $db->exec("INSERT INTO admins (login, password) VALUES ('admin', '123');");

        
        foreach($admins as $admin){
            $_SESSION['isAdmin'] = ($admin[1] == $login && $admin[2] == $password)? true: false;
            var_dump($admin[1]." ".$admin[2]);///////////////////////////////////////////////
        }
        // здесь, сообщение о том, что авторизация неуспешна
        // if (!$_SESSION['isAdmin]) message ....
    }

    public function _addTask($n, $em, $t){
        $n = $this->test_input($n);
        $em = $this->test_input($em);
        $t = $this->test_input($t);
       
        $db = $this->loadDB();        
        $db->exec("INSERT INTO tasks (name, email, task, status) VALUES ('$n', '$em', '$t', 'work')");
    }

    public function _delTask($id){        
        $db = $this->loadDB(); 
        $sql = "DELETE FROM tasks WHERE id=$id";
        $db->exec($sql);            
    }
    
    // сортировка
    public function _sortTask($name, $sort){
        $db = new PDO('sqlite:./mysqlite.sqlite');
        switch($name){
            case "name":
                $x = ($sort)?"SELECT * FROM tasks ORDER BY name ASC":"SELECT * FROM tasks ORDER BY name DESC";
                if (!isset($_SESSION['sortName'])) {
                    $_SESSION['sortName'] = true;
                } else {
                    $_SESSION['sortName'] = !$_SESSION['sortName'];
                }
            break;
            case "email":
                $x = ($sort)?"SELECT * FROM tasks ORDER BY email ASC":"SELECT * FROM tasks ORDER BY email DESC";
                if (!isset($_SESSION['sortEmail'])) {
                    $_SESSION['sortEmail'] = true;
                } else {
                    $_SESSION['sortEmail'] = !$_SESSION['sortEmail'];
                }
            break;
            case "status":
                $x = ($sort)?"SELECT * FROM tasks ORDER BY status ASC":"SELECT * FROM tasks ORDER BY status DESC";
                if (!isset($_SESSION['sortStatus'])) {
                    $_SESSION['sortStatus'] = true;
                } else {
                    $_SESSION['sortStatus'] = !$_SESSION['sortStatus'];
                }
            break;
            default:
            $x = "SELECT * FROM tasks";
        }                    
        $this->string = $db->query($x)->fetchAll();
    }
    // валидация
    public function validation($name, $email){
        // проверяем факт ввода имени
        if (empty($_POST["name"])) {
            return $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["name"]);
            // проверяем поле имя, оно должно содержать только буквы и пробелы   
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                return $nameErr = "Only letters and white space allowed";
            }
        }
    
        if (empty($_POST["email"])) {
            return $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // проверяем валидность email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $emailErr = "Invalid email format";
            }
        }      
    }
}