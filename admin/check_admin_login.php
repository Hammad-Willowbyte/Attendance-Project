<?php
include('database_connection.php');
session_start();
$admin_username = '';
$admin_password = '';
$error_admin_username = '';
$error_admin_password = '';
$error = 0;

if(empty($_POST["admin_username"]))
{
  $error_admin_username = 'user is required';
  $error++;
}else{
  $admin_username = $_POST["admin_username"];
}

if(empty($_POST["admin_password"]))
{
  $error_admin_password = 'password is required';
  $error++;
}else{
  $admin_password = $_POST["admin_password"];
}
if($error == 0){
    $query = 
    "SELECT * FROM admin WHERE admin_username='".$admin_username."'";

    $statement = $connect->prepare ($query);
    if($statement->execute()){
        $total_row = $statement->rowCount();
        if($total_row > 0)
        {
          $result = $statement->fetchAll();
        //   print_r($result);
        //   exit;
          foreach($result as $row){
            //   if(password_verify($admin_password, $row["admin_password"]))
            if($admin_password == $row["admin_password"] )
              {
                  $_SESSION["admin_id"]= $row["admin_id"];
             
              }
              else{
                 $error_admin_password= "wrong Password";
                 $error++;
              }
          }
        }
        else{
            $error_admin_username = 'Wrong Username';
            $error++; 
        }
    }
}
if($error > 0){
    $output =array(
      'error'     =>true,
      'error_admin_username' => $error_admin_username,
      'error_admin_password' => $error_admin_password,
    );
}
else{
    $output =array(
        'success'     =>true,
      );
}
echo json_encode($output);
?>