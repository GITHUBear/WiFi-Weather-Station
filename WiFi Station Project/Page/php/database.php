<?php

    function connectDB(){
    $conn = @mysql_connect('localhost', 'root', '');
    if (!$conn) {
        die("failed");
    }
    @mysql_query("SET NAMES UTF8");
    @mysql_select_db('wifistation', $conn) or die("connot find");
    return $conn;
    }
    function reverse($array){
        $size = count($array);

        for($i=0;$i<=floor($size/2);$i++){
            $b = $array[$size-$i-1];
            $array[$size-$i-1] = $array[$i];
            $array[$i] = $b;
        }
        return $array;

    }
    function weather(){
        $url = 'http://api.map.baidu.com/telematics/v3/weather?location=beijing&output=json&ak=AeRn2QES27pNjgo0DGzG048XZaEz6uyw';
        $html = file_get_contents($url);
        $weather_array = json_decode($html,true);
        $weather_info =  $weather_array['results'][0]['weather_data'][0]['weather'];
        if(strstr($weather_info,"晴")){
            return 'sun';
        }
        elseif(strstr($weather_info,'云')){
            return 'cloudy';
        }
        elseif(strstr($weather_info, "雨")){
            return 'rain';
        }
        elseif(strstr($weather_info, "雪")){
            return 'snow';
        }
        else{
            return 'default';
        }
    }
    function words(){
        $cloudy= array('狗才摸鱼',
                       '播了',
                       '才不改硬件端',
                       '改改HTML就好了嘛，轻轻松松');
        $sun = array('狗才摸鱼',
                     '播了',
                     '才不改硬件端',
                     '改改HTML就好了嘛，轻轻松松');
        $rain = array('狗才摸鱼',
                      '播了',
                      '才不改硬件端',
                      '改改HTML就好了嘛，轻轻松松');
        $snow = array('狗才摸鱼',
                      '播了',
                      '才不改硬件端',
                      '改改HTML就好了嘛，轻轻松松');
        $weather_info = weather();
        if($weather_info=="sun"){
            $random_key = array_rand($sun);
            return $sun[$random_key];
        }
        elseif($weather_info=='cloudy'){
            $random_key = array_rand($cloudy);
            return $cloudy[$random_key];
        }
        elseif($weather_info=='rain'){
            $random_key = array_rand($rain);
            return $rain[$random_key];
        }
        elseif($weather_info=='snow'){
            $random_key = array_rand($snow);
            return $snow[$random_key];
        }
        else{
            return "摸鱼组高清重置版";
        }

    }


?>



