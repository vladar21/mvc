<?php

class Model
{
    public $string;
    public $lastPage;
    public $currentPage;
    public $sortedField;
    public $sortedType;
    public $Count;
    // конструктор модели с параметрами
    public function __construct($page, $sT, $sF){      
        $db = $this->loadDB();
        $this->string = $db->query('SELECT * FROM tasks')->fetchAll();
        $this->Count = count($this->string);
        $this->lastPage = ceil($this->Count/3);
        $this->currentPage = $page;
        $this->sortedType = $sT;
        $this->sortedField = $sF;

        if ($this->currentPage == $this->lastPage){
            $offset = $this->Count - ($this->currentPage - 1) * 3;
        } else $offset = 3;
        $start = ceil($page)*3 - 3;    

        $x = "SELECT * FROM tasks ORDER BY $sF $sT LIMIT $start, $offset";        
        
        $this->string = $db->query($x)->fetchAll();
    }
    // загрузка данных из базы
    public function loadDB(){
        $db = new PDO('sqlite:./mysqlite.sqlite');
        $db->exec('CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY, name TEXT NOT NULL, 
            email TEXT NOT NULL, task TEXT NOT NULL, edited TEXT NOT NULL, stat TEXT NOT NULL)');
        
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
        // загружаем авторизационные данные из базы
        $db = new PDO('sqlite:./mysqlite.sqlite');
        $db->exec("CREATE TABLE IF NOT EXISTS admins (
            id INTEGER PRIMARY KEY, login TEXT NOT NULL, password TEXT NOT NULL);");
        
        $admins = $db->query("SELECT * FROM admins")->fetchAll();
        if (count($admins) == 0) $db->exec("INSERT INTO admins (login, password) VALUES ('admin', '123');");
        // проверяем авторизационные данные
        foreach($admins as $admin){
            $_SESSION['isAdmin'] = ($admin[1] == $login && $admin[2] == $password)? true: false;
        }
    }
    // добавляем задачу в базу
    public function _addTask($n, $em, $t){        
        $n = $this->test_input($n);
        $em = $this->test_input($em);
        $t = $this->test_input($t);        
        $db = $this->loadDB();   
        $db->exec("INSERT INTO tasks (name, email, task, edited, stat) VALUES ('$n', '$em', '$t', 'No', 'Work')");        
    }
    // удаляем задачу из базы
    public function _delTask($id){        
        $db = $this->loadDB(); 
        $sql = "DELETE FROM tasks WHERE id=$id";
        return ($db->exec($sql))?1:0;                  
    }
    // вносим изменения в данные задачи
    public function _updateTask($id){        
        $db = $this->loadDB(); 
        $n = $_POST['name'];
        $em = $_POST['email'];
        $t = $_POST['task'];
        $ed = 'Yes';
        $st = ($_POST['stat'])?$_POST['stat']:'Work';
        $sql = "UPDATE tasks SET name='$n', email='$em', task='$t', edited='$ed', stat='$st' WHERE id='$id'";
        $db->exec($sql);            
    }
    
    // сообщения
    public function message($msgIndex){
        switch($msgIndex){
            case 1:
                $_SESSION['message'] = "Вы успешно добавили новую задачу.";
            break;
            case 2:
                $_SESSION['message'] = "Вы успешно удалили задачу.";
            break;
            case 3:
                $_SESSION['message'] = "Вы успешно обновили задачу.";
            break;
            case 4:
                $_SESSION['message'] = "Вы успешно залогинились.";
            break;
            case 5:
                $_SESSION['message'] = '<span style="color:red;font-weight:bold">ВНИМАНИЕ! Ошибка в имени и/или пароле.</span>';
            break;
            case 6:
                $_SESSION['message'] = "До свидания, Admin!";
            break;
            case 7:
                $_SESSION['message'] = '<span style="color:red;font-weight:bold">ВНИМАНИЕ! Введите имя.</span>';
            break;
            case 8:
                $_SESSION['message'] = '<span style="color:red;font-weight:bold">ВНИМАНИЕ! Вводите в поле "name" только буквы и пробелы.</span>';
            break;
            case 9:
                $_SESSION['message'] = '<span style="color:red;font-weight:bold">ВНИМАНИЕ! Введите email.</span>';
            break;
            case 10:
                $_SESSION['message'] = '<span style="color:red;font-weight:bold">ВНИМАНИЕ! Невалидный email формат.</span>';
            break;
            case 11:
                $_SESSION['message'] = '<span style="color:red;font-weight:bold">ВНИМАНИЕ! Необходимо авторизоваться.</span>';
            break;
            case 12:
                $_SESSION['message'] = '<span style="color:red;font-weight:bold">ВНИМАНИЕ! Запись не была удалена.</span>';
            break;
        }
    }

    // валидация
    public function validation($name, $email){
        // проверяем факт ввода имени
        if (empty($_POST["name"])) {          
            return 7;
        } else {
            $name = $this->test_input($_POST["name"]);
            // проверяем поле имя, оно должно содержать только буквы и пробелы   
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                return 8;
            }
        }
    
        if (empty($_POST["email"])) {
            return 9;
            //return $emailErr = "Email is required";
        } else {
            $email = $this->test_input($_POST["email"]);
            // проверяем валидность email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 10;
                //return $emailErr = "Invalid email format";
            }
        }      
    }
    // заверщаем сессию админа
    public function logout(){
        return $_SESSION['isAdmin'] = false;
    }
}