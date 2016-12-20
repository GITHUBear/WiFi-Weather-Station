<?php

include "php/database.php";

$conn = connectDB();

$result_tem = mysql_query('SELECT temperature FROM weatherdata ORDER BY id DESC LIMIT 0,1');
$result_hum = mysql_query('SELECT humidity FROM weatherdata ORDER BY id DESC LIMIT 0,1');
$result_ill = mysql_query('SELECT lightness FROM weatherdata ORDER BY id DESC LIMIT 0,1');

$result_tem_arr = mysql_fetch_assoc($result_tem);
$result_hum_arr = mysql_fetch_assoc($result_hum);
$result_ill_arr = mysql_fetch_assoc($result_ill);

$tem = $result_tem_arr['temperature'];
$hum = $result_hum_arr['humidity'];
$ill = $result_ill_arr['lightness'];

$status = weather();
$word = words();
?>

<!DOCTYPE html>
<html>

<head>
    <title>摸鱼气象站</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
</head>

<body style="background-image: url('img/<?=$status?>.jpg')">
<div class="container">

    <div class="info">

        <svg class="circle" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50%" cy="50%" r="165" stroke=#5CACEE stroke-width="3" fill="none" />
        </svg>

        <div class="temp">
            <p id="data1"></p>
        </div>

        <div class="hum">
            <img class="icon" alt="26*26" src="img/hum.png" />
            <p id="data2"></p>
            <img class="icon" alt="26*26" src="img/light.png" />
            <p id="data3"></p>
        </div>

    </div>


    <a id="btn" href="history.php">历史数据</a>

    <p id="sentence"></p>


</div>
<script type="text/javascript">
    var temp,hum,light,word,img;
    temp='<?=$tem?>';
    hum='<?=$hum?>';
    light='<?=$ill?>';
    word='<?=$word?>';
    document.getElementById("data1").innerHTML=temp+"℃";
    document.getElementById("data2").innerHTML=hum+"%";
    document.getElementById("data3").innerHTML=light+"lx";
    document.getElementById("sentence").innerHTML=word;

</script>
</body>

</html>