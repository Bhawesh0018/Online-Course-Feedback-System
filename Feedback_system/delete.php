<!-- ========== delete.php ========== -->
<?php include "db.php";
$id = $_POST['id'];
$conn->query("DELETE FROM feedback WHERE id=$id");
?>