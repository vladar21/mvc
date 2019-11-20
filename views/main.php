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
   
    <form action="add" class="form-inline" method="POST">            
        <input type="text" name="name" placeholder="Input Name" class="form-control col-md-2">    
        <input type="email" name="email" placeholder="Input Email" class="form-control col-md-2"> 
        <input type="text" name="task" placeholder="Input Task" class="form-control col-md-6">   
        <button type="submit" class="btn btn-primary col-md-2">AddNewTask</button>
    </form> 
  
    <div class="container-fluid">
        <div class="row">
            <!-- <button type="submit" class="btn btn-outline-danger autoriz btn-md" form="newtask">Login</button> -->
            <a href="/login" class="btn btn-outline-danger autoriz btn-md">Login</a>
            <h1 class="col-md-11">Task`s Desk</h1>
        </div>            
            
        <div class="row head">
            <div class="col-md-2"><a href="/sort/name"><h2>name</h2></a></div>
            <div class="col-md-2"><a href="/sort/email"><h2>email</h2></a></div>
            <div class="col-md-6"><h2>task</h2></div>
            <div class="col-md-1"><a href="/sort/status"><h2>status</h2></a></div>
        </div> 
        <?php if ($data){
            
            foreach($data as $str){
                echo '<div class="row">';
                echo '<div class="col-md-2"><h3>'.$str[1].'</h3></div>';
                echo '<div class="col-md-2"><h3>'.$str[2].'</h3></div>';
                echo '<div class="col-md-6"><h3>'.$str[3].'</h3></div>';
                echo '<div class="col-md-1 form-check-inline"><h3 style="margin:auto;">'.$str[4].'</h3></div>';
                // echo '<div class="col-md-1"><a href="/del/'.$str[0].'" class="btn btn-danger del btn-md" form="newtask">Del</a></div>';
                echo '</div>';
            }
            
        }
        ?>
    </div>
</body>
</html>