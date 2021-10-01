<?php

$connect = new PDO("mysql:host=localhost;dbname=attendance","root","");
// $base_url = "http://localhost/tutorial/student-attendance-system-in-php-using-ajax/";
$base_url = "http://localhost/Attendance/attendance/index.php";

function get_total_records($connect, $table_name)
{
 $query = "SELECT * FROM $table_name";
 $statement = $connect->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}

function load_grade_list($connect)
{
 $query = "SELECT * FROM tbl_grade ORDER BY grade_name ASC";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  $output .= '<option value="'.$row["grade_id"].'">'.$row["grade_name"].'</option>';
 }
 return $output;
}

function get_attendance_percentage($connect, $student_id)
{
 $query = " SELECT 
  ROUND((SELECT COUNT(*) FROM tbl_attendance 
  WHERE attendance_status = 'Present' 
  AND student_id = '".$student_id."') 
 * 100 / COUNT(*)) AS percentage FROM tbl_attendance 
 WHERE student_id = '".$student_id."'
 ";

 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  if($row["percentage"] > 0)
  {
   return $row["percentage"] . '%';
  }
  else
  {
   return 'NA';
  }
 }
}


?>