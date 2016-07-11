<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/conf.php");
	include_once($DOC_ROOT."/cookies.php");
	include_once($DOC_ROOT."/cache.php");
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/list.php">Redirector</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="/list.php">List</a></li>
      <li><a href="/backend/log.php">Log</a></li>
      <li><a href="/backend/add.php">Add URL</a></li>
	  	<!-- <li><a href="/backend/my_urls.php">My URLS</a></li> NYI -->
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php
        $session_token = has_session();
        if($session_token == false){
          echo "<li><a href='/login.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
        }else{
          echo "<li><a>".get_cached_user($session_token)."</a></li>";
          echo "<li><a href='/logout.php'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>";
        }
      ?>
    </ul>
  </div>
</nav>
