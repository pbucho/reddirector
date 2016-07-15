<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT']."/includes";
	include_once($DOC_ROOT."/conf.php");
	include_once($DOC_ROOT."/cookies.php");
	include_once($DOC_ROOT."/cache.php");
	include_once($DOC_ROOT."/meta.php");
	include_once($DOC_ROOT."/roles.php");
	global $SITE_NAME;

	$session_token = cookies_has_session();
	$roles_is_admin = roles_is_admin(cache_get_cached_user($session_token));
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/list.php"><?php echo $SITE_NAME; ?></a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="/list.php">List</a></li>
			<?php
	  		if($session_token != false){
					echo "<li><a href='/backend/my_urls.php'>My URLs</a></li>";
				}
				if($roles_is_admin){
					echo "<li><a href='/backend/access_log.php'>Access log</a></li>";
				}
			?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php
        if($session_token == false){
          echo "<li><a href='/login.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
        }else{
					if(roles_is_admin(cache_get_cached_user($session_token))){
						echo "<li><a><b><kbd>admin</kbd></b></a></li>";
					}
          echo "<li><a href='/backend/control_panel.php'>".cache_get_cached_user($session_token)."</a></li>";
          echo "<li><a href='/logout.php'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>";
        }
      ?>
    </ul>
  </div>
</nav>
