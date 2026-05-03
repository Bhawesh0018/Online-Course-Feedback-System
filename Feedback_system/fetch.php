<!-- ========== fetch.php ========== -->
<?php 
include "db.php";


$q = $conn->query("SELECT * FROM feedback");

while($r = $q->fetch_assoc()){
    
    // ⭐ Convert rating to stars
   
    $stars = "";
    for($i = 1; $i <= 5; $i++){
    if($i <= $r['rating']){
        $stars .= "<span class='star filled'>★</span>";
    } else {
        $stars .= "<span class='star'>☆</span>";
    }
}
    echo "<tr>
        <td>{$r['id']}</td>
        <td>{$r['course']}</td>
        <td>$stars</td>
        <td>{$r['message']}</td>
        <td>";
        
    if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){
        echo "<button class='btn btn-danger btn-sm' onclick='deleteFeedback({$r['id']})'>Delete</button>";
    }

    echo "</td></tr>";
}
?>