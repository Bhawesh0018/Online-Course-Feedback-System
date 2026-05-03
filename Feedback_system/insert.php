<?php include "db.php";
$c=$_POST['course'];
$r=$_POST['rating'];
$m=$_POST['msg'];
$conn->query("INSERT INTO feedback(course,rating,message) VALUES('$c','$r','$m')");
?>