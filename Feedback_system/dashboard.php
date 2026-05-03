<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>

/* 🌄 Background */
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1551288049-bebda4e38f71');
    background-size: cover;
    background-attachment: fixed;
    color: white;

}


/* Layout */
.sidebar {
    width: 240px;
    height: 100vh;
    position: fixed;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(10px);
}

.content {
    margin-left: 260px;
    padding: 20px;
}

/* Sidebar Links */
.sidebar a {
    color: white;
    display: block;
    padding: 12px;
    text-decoration: none;
    transition: 0.3s;
    border-radius: 8px;
}

.sidebar a:hover {
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    padding-left: 20px;
}

/* Export Buttons Highlight */
.sidebar a:nth-child(3),
.sidebar a:nth-child(4) {
    background: linear-gradient(45deg, #ff512f, #dd2476);
    margin-top: 10px;
    text-align: center;
}

.sidebar a:nth-child(3):hover,
.sidebar a:nth-child(4):hover {
    box-shadow: 0 0 15px #ff512f;
}

/* Cards */
.card {
    border-radius: 15px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(12px);
    color: white;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

/* Chart */
canvas {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 10px;
    margin-top: 20px;
}

/* Table */
table {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    overflow: hidden;
    color: white;
}

th {
    background: rgba(0,0,0,0.7);
}

/* Button */
.toggle-btn {
    background: #0072ff;
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    margin-bottom: 10px;
}
.star {
    font-size: 18px;
    color: #ccc;
    transition: transform 0.2s ease, text-shadow 0.2s ease;
    display: inline-block;
}

.star.filled {
    color: gold;
}

/* ✨ Hover animation */
.star:hover {
    transform: scale(1.3);
    text-shadow: 0 0 8px gold;
}


</style>

</head>
<body>
<div id="toast" style="
position: fixed;
bottom: 20px;
right: 20px;
background: #28a745;
color: white;
padding: 12px 20px;
border-radius: 8px;
display: none;">
✔ Action Successful
</div>
    

<!-- Sidebar -->
<div class="sidebar p-3">
    <h4>Admin Panel</h4>
    <a href="#">Dashboard</a>
    <a href="#feedbackTable">Feedback</a>
    <a href="export_excel.php">Export Excel</a>
    <a href="export_pdf.php">Export PDF</a>
</div>

<!-- Content -->
<div class="content">
    <h2>Dashboard</h2>

    <div class="row g-3">
        <?php
        $total = $conn->query("SELECT COUNT(*) c FROM feedback")->fetch_assoc()['c'];
        $avg = $conn->query("SELECT AVG(rating) a FROM feedback")->fetch_assoc()['a'];
        ?>

        <div class="col-md-4">
           <div class="card p-3">
                <h6>Total Feedback</h6>
                <h2><?php echo $total; ?></h2>
                <small>All submitted reviews</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Average Rating</h5>
                <h3><?php echo round($avg,2); ?></h3>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <canvas id="courseChart"></canvas>
    <canvas id="coursePie"></canvas>
    
    <script>
    function showToast(){
    $('#toast').fadeIn().delay(2000).fadeOut();
    }
    showToast();
    </script>
    <script>
        
    $.get("chart_data.php", function(data){
        let d = JSON.parse(data);
        new Chart(document.getElementById('courseChart'), {
            type: 'bar',
            data: {
                labels: d.labels,
                datasets: [{
                    label: 'Ratings',
                    data: d.data
                }]
            }
        });
    });
    $.get("chart_data.php", function(data){
 let d = JSON.parse(data);

 new Chart(document.getElementById('courseChart'), {
  type: 'bar',
  data: {
    labels: d.labels,
    datasets: [{ label:'Ratings', data:d.data }]
  }
 });

 new Chart(document.getElementById('coursePie'), {
  type: 'doughnut',
  data: {
    labels: d.labels,
    datasets: [{ data:d.data }]
  }
 });
});
    </script>

    <!-- Table -->
    <h3 class="mt-4" id="feedbackTable">Feedback List</h3>
<input type="text" id="search" class="form-control mb-2" placeholder="Search feedback...">

    <table class="table table-bordered mt-2">
        <tr>
            <th>ID</th>
            <th>Course</th>
            <th>Rating</th>
            <th>Message</th>
            
        </tr>
        <tbody id="data"></tbody>
    </table>
</div>

<script>
    $('#search').on('keyup', function(){
    let val = $(this).val().toLowerCase();
    $("#data tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1)
    });
});
function loadData(){
    $.get("fetch.php", function(res){
        $('#data').html(res);
    });
}
loadData();

function deleteFeedback(id){
    if(confirm("Delete?")){
        $.post("delete.php", {id:id}, function(){
            loadData();
        });
    }
}
</script>

</body>
</html>