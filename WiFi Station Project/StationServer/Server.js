/**
 * 实现一个可以接收传感器数据的服务器，架构在本地上
 */
/**
 * Created by zhangxue on 16/10/17.
 */
/**
 * Server 处理post请求
 */
var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var mysql = require('mysql');   //调用mysql模块

//app.use(bodyParser.json({type:['application/json']}));
app.use(bodyParser.urlencoded({ extended: true}));
app.use(express.static('public'));

app.post('/process',function (req, res) {

    response=req.query;
    console.log(response);
    res.send('post succeed');
    var connection = mysql.createConnection({
        host: '127.0.0.1',
        user: 'root',
        password: '',
        port: '3306',
        database: 'wifistation'             //数据库名称
    });

//建立连接
    connection.connect(function (err) {
        if (err) {
            console.log('[query] - :' + err);
            return;
        }
        console.log('[connection connect] succeed!');
    });

    var insertSQL = 'insert into weatherdata (temperature,humidity,lightness) values(?,?,?)';
    var Params = [response.tem, response.hum, response.light];

//执行查询
    connection.query(insertSQL, Params, function (err, result) {

        if (err) {
            console.log('[Insert Error] - ', err.message);
            return;
        }
        console.log('insert succeed!');
    });

//关闭connection
    connection.end(function (err) {
        if (err) {
            return;
        }
        console.log('[connection end] succeed!');
    });

});
var server = app.listen(3005, function () {

    var host = server.address().address
    var port = server.address().port

    console.log("应用实例，访问地址为 http://%s:%s", host, port)

})
