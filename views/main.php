<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <title>TaskDesk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body{
            font-size:14pt;
            font-weight:bold;
        }
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
   <?php 
    if (isset($_SESSION['show']) && $_SESSION['show'] <= 2){
       echo '<div class="container-fluid"><div class="alerct alert-info">'.$_SESSION['message'].'</div></div>';
       $_SESSION['show']++;
   }  ?>
    <form action="add" class="form-inline" method="POST">            
        <input type="text" name="name" placeholder="Input Name" class="form-control col-md-2">    
        <input type="text" name="email" placeholder="Input Email" class="form-control col-md-2"> 
        <input type="text" name="task" placeholder="Input Task" class="form-control col-md-6">   
        <button type="submit" class="btn btn-primary col-md-2">AddNewTask</button>
    </form> 
  
    <div class="container-fluid">
        <div class="row">
            <a href="/login" class="btn btn-outline-danger autoriz btn-md">Login</a>
            <h1 class="col-md-11">Task`s Desk</h1>
        </div>            
            
        <div class="row head">
            <div class="col-md-2"><a href="/sort/name"><h2>name</h2></a></div>
            <div class="col-md-2"><a href="/sort/email"><h2>email</h2></a></div>
            <div class="col-md-6"><h2>task</h2></div>
            <div class="col-md-1"><h2>edited</h2></div>
            <div class="col-md-1"><a href="/sort/stat"><h2>status</h2></a></div>
        </div> 
        <?php if ($data){
            
            foreach($data as $str){
                echo '<div class="row">';
                echo '<div class="col-md-2">'.$str[1].'</div>';
                echo '<div class="col-md-2">'.$str[2].'</div>';
                echo '<div class="col-md-6">'.$str[3].'</div>';
                echo '<div class="col-md-1">'.$str[4].'</div>';
                echo '<div class="col-md-1">'.$str[5].'</div>';
                echo '</div>';
            }
            
        }        

        echo '<nav aria-label="Статьи по Bootstrap 4">';
            echo '<ul class="pagination justify-content-center">';
                echo '<li class="page-item">'.(($currentPage == 1)?(" "):('<a class="page-link active" href="/page/1">1</a>')).'</li>';
                echo '<li class="page-item">'.(($lastPage == 1 || $lastPage == 2 || $currentPage == 1)?(" "):('<a class="page-link" href="/page/'.($currentPage - 1).'"><</a>')).'</li>';
                echo '<li class="page-item">'.(($lastPage == 1)?(" "):('<a class="page-link" href="/page/'.$currentPage.'" style="color:black;">'.$currentPage.'</a>')).'</li>';
                echo '<li class="page-item">'.(($lastPage == 1 || $lastPage == $currentPage)?(" "):('<a class="page-link" href="/page/'.($currentPage + 1).'">></a>')).'</li>';
                echo '<li class="page-item">'.(($lastPage == 1 || $lastPage == $currentPage)?(" "):('<a class="page-link" href="/page/'.$lastPage.'">'.$lastPage.'</a>')).'</li>';
            echo '</ul>';
        echo '</nav>';

        ?>

    </div>
</body>
</html>