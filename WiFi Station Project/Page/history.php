<?php
    include "php/database.php";
    $conn = connectDB();
    //取之前1小时温度
    $result_tem = mysql_query('SELECT temperature FROM weatherdata ORDER BY id DESC LIMIT 0,700');
    $result_tem_arr = array();   //存储数组
    while($rows=mysql_fetch_array($result_tem)){      //$rows是数组
        settype($rows['temperature'],'int');          //string变成float
        $result_tem_arr[] =$rows['temperature'];        //提取赋值
    }
    $result_tem_arr = reverse($result_tem_arr);
    $json_tem_1 = json_encode($result_tem_arr);       //转化为json格式
    $result_hum = mysql_query('SELECT humidity FROM weatherdata ORDER BY id DESC LIMIT 0,700');
    $result_hum_arr = array();   //存储数组
    while($rows=mysql_fetch_array($result_hum)){      //$rows是数组
        settype($rows['humidity'],'float');          //string变成float
        $result_hum_arr[] =$rows['humidity'];        //提取赋值
    }
    $result_hum_arr = reverse($result_hum_arr);
    $json_hum_1 = json_encode($result_hum_arr);       //转化为json格式
    $result_ill = mysql_query('SELECT lightness FROM weatherdata ORDER BY id DESC LIMIT 0,700');
    $result_ill_arr = array();                           //存储数组
    while($rows=mysql_fetch_array($result_ill)){         //$rows是数组
        settype($rows['lightness'],'float');
        $result_ill_arr[] =$rows['lightness']/10;        //提取赋值
    }
    $result_ill_arr = reverse($result_ill_arr);
    $json_ill_1 = json_encode($result_ill_arr);       //转化为json格式
    $status = weather();                        //更换背景图片
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>摸鱼气象站</title>
    <script src="js/echarts.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
    <script>

    //温度图
    option_tem_1 = {
        grid:{
            show:true,
            y:'3%',
            borderWidth:0
        },
        tooltip: {                    //在移动过程中显示数据
            trigger: 'item'
        },
        legend: {               //图例
            show:true,
            data:['温度','湿度','光照/10'],
            textstyle: {
                color: 'white'
            }
        },
        dataZoom:[
            {
                type: 'slider',
                show: true,
                xAxisIndex: [0],
                start: 94,
                end: 100,
                showDataShadow:true
            },
            {
                start: 94,
                end: 100,
                handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
                handleSize: '80%',
                handleStyle: {
                    color: '#fff',
                    shadowBlur: 3,
                    shadowColor: 'rgba(0, 0, 0, 0.6)',
                    shadowOffsetX: 2,
                    shadowOffsetY: 2
                }
            },
            {
                type: 'inside',
                xAxisIndex: [0],
                start: 94,
                end: 100
            }
            ],

        toolbox: {
            show: true
        },
        xAxis:  {
            show:true,
            type: 'category',
            axisLabel:{      //坐标轴
                textStyle:{
                    fontSize:30,
                    color:'#f8f4ff'
                }
            },
            axisLine:{
                lineStyle:{
                    color:'white'
                }
            },
            boundaryGap: false,
            splitLine: {
                show: false
            },
            data:[]
        },

        yAxis: {
            show:true,
            type: 'value',
            boundaryGap:true,
            scale: true,
            boundaryGap:[0.01,0.01],
            axisLabel: {
                formatter: '{value} °C'     //纵坐标
            },
            splitLine: {
                show: true
            }

        },
        series: [
            {
                name:'温度',
                type:'bar',
                label:{
                    normal:{
                        textStyle:{
                            fontSize:20
                        }
                    }
                },
                formatter:'{line}°C',
                itemStyle : {
                    normal: {
                        label: {
                            show: false,     //每个点显示数据
                            position: 'top'
                        },
                        color: '#ff8e9a'    //修改颜色
                    }
                },
                data:<?=$json_tem_1?>,
                animationDelay: function (idx) {
        return idx * 3;}
            },
            {
                name:'湿度',
                type:'bar',
                label:{
                    normal:{
                        textStyle:{
                            fontSize:20
                        }
                    }
                },
                //formatter:'{line}°C',
                itemStyle : {
                    normal: {
                        label : {
                            show: false,     //每个点显示数据
                            position: 'top'
                        },
                        color :'#ffa64f'    //修改颜色
                    }
                },
                data:<?=$json_hum_1?>,
                animationDelay: function (idx) {
        return idx * 3;}
            },
            {
                name:'光照/10',
                type:'bar',
                label:{
                    normal:{
                        textStyle:{
                            fontSize:20
                        }
                    }
                },
                data:  <?=$json_ill_1?>,

                itemStyle : {
                    normal: {
                        label : {
                            show: false,     //每个点显示数据
                            position: 'top'
                        },
                        color : '#ffdcbd' //修改颜色

                    }
                }
            }

        ],
        animationEasing: 'elasticOut',
        animationDelayUpdate: function (idx) {
            return idx * 3;}
    };
    </script>
    <style type="text/css">
    .float-right { float: right; }
    .clear { clear: both; }
    </style>
</head>
<body style="background-image: url('img/<?=$status?>.jpg')">
<div class="chart" >
    <div class="row">
        <div class="col-md-10 col-sm-10" id="chart_tem" style="width: 100%;height:450px;margin: 0 auto" ,style="position:absolute; left:50%;  margin-left:-250px; top:50%; margin-top:-5000px;">
        </div>
        <div class="clearfix visible-sm"></div>
    </div>
</div>

<script type="text/javascript">
    var ele = [document.getElementById('chart_tem')];
    var myChart_tem = echarts.init(ele[0]);
    var option_tem = option_tem_1;
    myChart_tem.setOption(option_tem_1);
    var period = 1;
    function show() {
        myChart_tem.clear(option_tem);
                ele[0].style.display = "block";
        switch (period) {
            case 1:
                option_tem = option_tem_1;
                break;
            case 8:
                option_tem = option_tem_8;
                break;
            case 24:
                option_tem = option_tem_24;
                break;
        }
        myChart_tem.setOption(option_tem);
    }
    show();
    window.onresize = function () {
        myChart_tem.resize();
    }
    </script>
</body>
</html>
