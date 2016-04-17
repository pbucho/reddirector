<?php include_once("conf.php"); ?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Redirector</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="list.php">List</a></li>
      <li><a href="log.php">Log</a></li>
      <li><a href="backend/add.php">Add</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php
        $session = has_session();
        if($session == false){
          echo "<li><a href='login.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
        }else{
          echo "<li>$session</li>";
          echo "<li><a href='#'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>";
        }
      ?>
    </ul>
  </div>
</nav>
