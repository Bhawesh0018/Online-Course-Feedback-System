<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
body {
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    transition: background-image 0.5s ease-in-out;
}

/* Glass Form */
.container-box {
    background: rgba(255, 255, 255, 0.85);
    padding: 25px;
    border-radius: 12px;
    max-width: 400px;
    margin: auto;
    margin-top: 80px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
}

/* ⭐ Stars */
.stars {
    display: flex;
    gap: 8px;
    font-size: 28px;
    cursor: pointer;
}

.star {
    color: #ccc;
    transition: transform 0.2s, color 0.2s;
}

.star.hover,
.star.active {
    color: gold;
    transform: scale(1.2);
}
</style>

</head>

<body>

<div class="container-box">
    <h3>Submit Feedback</h3>

    <select id="course" class="form-control mb-2">
        <option value="web">Web Dev</option>
        <option value="ai">AI</option>
        <option value="python">Python</option>
        <option value="data">Data Science</option>
    </select>

    <!-- ⭐ Star Rating -->
    <div class="stars mb-3">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>
    </div>

    <input type="hidden" id="rating">

    <textarea id="msg" class="form-control mb-2" placeholder="Your feedback"></textarea>

    <button class="btn btn-success w-100" onclick="send()">Submit</button>
</div>

<script>
let selectedRating = 0;

/* ⭐ Star Logic */
$('.star').on('mouseover', function() {
    let val = $(this).data('value');
    $('.star').each(function() {
        $(this).toggleClass('hover', $(this).data('value') <= val);
    });
});

$('.star').on('mouseout', function() {
    $('.star').removeClass('hover');
});

$('.star').on('click', function() {
    selectedRating = $(this).data('value');
    $('#rating').val(selectedRating);

    $('.star').each(function() {
        $(this).toggleClass('active', $(this).data('value') <= selectedRating);
    });
});

/* 🌄 Dynamic Background */
function changeBackground(course) {
    let bg = "";

    switch(course) {
        case "web":
            bg = "https://images.unsplash.com/photo-1498050108023-c5249f4df085";
            break;
        case "ai":
            bg = "https://images.unsplash.com/photo-1677442136019-21780ecad995";
            break;
        case "python":
            bg = "https://images.unsplash.com/photo-1526379095098-d400fd0bf935";
            break;
        case "data":
            bg = "https://images.unsplash.com/photo-1551288049-bebda4e38f71";
            break;
    }

    $('body').css('background-image', 'url(' + bg + ')');
}

/* Trigger on change */
$('#course').on('change', function() {
    changeBackground($(this).val());
});

/* Set default background on load */
$(document).ready(function(){
    changeBackground($('#course').val());
});

/* Submit */
function send(){
 if(selectedRating == 0){
    alert("Please select rating");
    return;
 }

 $.post("insert.php", {
  course: $('#course').val(),
  rating: selectedRating,
  msg: $('#msg').val()
 }, function(){ 
    alert("Submitted"); 
 });
}
</script>

</body>
</html>