<?php
  include_once("base.php");

  function roles_is_admin($user){
    if(is_null($user) || $user == false){
      return false;
    }

    $sqlRoleAdmin = "SELECT role_id FROM roles r INNER JOIN users u ON r.user_id = u.id WHERE u.name = '$user'";
    $conn = base_get_connection();
    $result = $conn->query($sqlRoleAdmin);
    $conn = null;

    foreach ($result as $role) {
      if($role['role_id'] == 0){
        return true;
      }
    }
    return false;
  }
?>
