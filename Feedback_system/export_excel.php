<?php include "db.php";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=feedback.xls");
$res = $conn->query("SELECT * FROM feedback");
echo "ID\tCourse\tRating\tMessage\n";
while($r=$res->fetch_assoc()){
 echo "{$r['id']}\t{$r['course']}\t{$r['rating']}\t{$r['message']}\n";
}
?>