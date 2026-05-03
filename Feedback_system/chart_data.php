<!-- ========== chart_data.php ========== -->
<?php include "db.php";
$res = $conn->query("SELECT course, AVG(rating) r FROM feedback GROUP BY course");
$labels=[]; $data=[];
while($row=$res->fetch_assoc()){
 $labels[]=$row['course'];
 $data[]=$row['r'];
}
echo json_encode(["labels"=>$labels,"data"=>$data]);
?>