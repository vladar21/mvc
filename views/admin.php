<?php
require_once('View.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <title>TaskDesk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .head {
            background-color: aquamarine;
        }
        h1 {
            text-align:center;
        }
        .head, .alert-info {
            text-align: left;
        }
        .alert-info{
            font-size: 16pt;
            font-weight: bold;
            color:brown
        }
        .btn {
            font-size: 16pt;
        }
        .autoriz {
            font-size: 14pt;
            line-height: 2.5;
            margin-bottom: 3px;
        }
        .del {
            margin-top: 3px;
        }

    </style>
</head>
<body>

 
    <form action="admin/add" class="form-inline" method="POST">            
        <input type="text" name="name" placeholder="Input Name" class="form-control col-md-2">    
        <input type="email" name="email" placeholder="Input Email" class="form-control col-md-2"> 
        <input type="text" name="task" placeholder="Input Task" class="form-control col-md-6">   
        <button type="submit" class="btn btn-primary col-md-2">AddNewTask</button>
    </form> 
  
    <div class="container-fluid">
        <div class="row">
            <!-- <button type="submit" class="btn btn-outline-danger autoriz btn-md" form="newtask">Login</button> -->
            <a href="/logout" class="btn btn-outline-primary autoriz btn-md">Logout</a>
            <h1 class="col-md-11">Task`s Desk</h1>
        </div>            
            
        <div class="row head">
            <div class="col-md-2"><a href="/admin/sort/name"><h2>name</h2></a></div>
            <div class="col-md-2"><a href="/admin/sort/email"><h2>email</h2></a></div>
            <div class="col-md-5"><h2>task</h2></div>
            <div class="col-md-1"><a href="/admin/sort/status"><h2>status</h2></a></div>
            <div class="col-md-2"><h2>admin</h2></div>            
        </div> 
        <?php if ($data){
            
            foreach($data as $str){
                echo '<form class="form-inline" method="POST" action="/admin/update/'.$str[0].'">';
                //echo '<div class="input-group">';
                echo '<div class="col-md-2"><input type="text" class="input-group form-control" name="name" value="'.$str[1].'"></div>';
                // echo '<div class="col-md-2">'.$str[1].'</h3></div>';
                echo '<div class="col-md-2"><input type="text" class="input-group form-control" name="email" value="'.$str[2].'"></div>';
                echo '<div class="col-md-5"><input type="text" class="input-group form-control" name="task" style="width:100%; max-width:100%;" value="'.$str[3].'"></div>';
                echo '<div class="col-md-1"><input type="checkbox" class="input-group form-control form-check-input" name="status" id="Check1" value="Done"" '.(($str[4] == "Done")?'checked':'unchecked').'></div>';
                echo '<div class="col-md-1"><button type="submit" class="input-group form-control btn btn-primary">Update</button></div>';
                echo '<div class="col-md-1"><a href="/admin/del/'.$str[0].'" class="input-group form-control btn btn-danger del">Del</a></div>';
                //echo '</div>';
                echo '</form>';
            }
            
        }
        ?>

        <nav aria-label="Статьи по Bootstrap 4">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Предыдущая</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Следующая</a></li>
            </ul>
        </nav>

    </div>
</body>
</html>