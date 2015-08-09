<?php
//http://app.com/list.php?page =1&pageSize=12
header("Content-type: text/html; charset=utf-8");
require_once('DB/response.php');
require_once('DB/db.php');
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 6;
if(!is_numeric($page) || !is_numeric($pageSize)) {
    return Response::show(401, '数据不合法');//不再执行下面的程序return
}
$offset = ($page - 1)*$pageSize;
//$sql = "SELECT * FROM balanceSheetTotal WHERE category = '所有者权益' ORDER BY id DESC LIMIT ".$offset.",".$pageSize;
$sql = "select * from `doubleEntry` where month(date) = 5 LIMIT 0, 30 ";
// echo $sql;

try {
    $connect = Db::getInstance()->connect();
} catch(Exception $e) {
    return Response::Show(403, '数据库链接失败');
}
$result = mysql_query($sql, $connect);

$entries = array();

while($entry = mysql_fetch_assoc($result)){
    $entries[] = $entry;
    echo "{$entry['deal_no']}";
    
}
var_export($entries);


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="format-detection" content="email=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="applicable-device" content="mobile">
    <meta name="apple-itunes-app" content="app-id=921839681">
    <script>
    if (/MSIE (6.0|7.0|8.0)/.test(navigator.userAgent)) {
        location.href = location.protocol + "//" + location.hostname + '/nonsupport.html';
    }
    </script>
    <title>资产负债表</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="dashboard.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <!-- Bootstrap core js -->
</head>
<?php
    if(!empty($_GET['date'])){
        echo "greeting, {$_GET['date']}";
    }

?>

<body id="body">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- 用户名 -->
                <a class="navbar-brand" href="#">小云</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li data-tab="balanceSheet"><a href="javascript:;">资产负债表</a></li>
                    <li data-tab="incomeStatement"><a href="javascript:;">损益表</a></li>
                    <li data-tab="doubleEntry"><a href="javascript:;">复式记账法</a></li>
                    <li><a href="javascript:;">收入</a></li>
                    <li data-tab="expense"><a href="javascript:;">支出</a></li>
                    <li><a href="javascript:;">转账</a></li>
                    <li><a href="javascript:;">对账</a></li>
                    <li><a href="javascript:;">统计</a></li>
                    <li><a href="javascript:;">基金</a></li>
                    <li><a href="javascript:;">股票</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
<!--         <div class="row">
            <div id="sidebar" class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active" data-tab="balanceSheet"><a href="javascript:;">资产负债表 <span class="sr-only">(current)</span></a></li>
                    <li data-tab="incomeStatement"><a href="javascript:;">损益表</a></li>
                    <li data-tab="doubleEntry"><a href="javascript:;">复式记账法</a></li>
                </ul>
                <ul class="nav nav-sidebar">
                    <li><a href="">收入</a></li>
                    <li data-tab="expense"><a href="">支出</a></li>
                    <li><a href="">转账</a></li>
                </ul>
                <ul class="nav nav-sidebar">
                    <li><a href="">对账</a></li>
                    <li><a href="">统计</a></li>
                    <li><a href="">基金</a></li>
                    <li><a href="">股票</a></li>
                </ul>
            </div>
        </div> -->
            <div id="doubleEntry" class="col_tb_5 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
                <div class="row">
                    <div class="col-xs-5 col-sm-5">
                        <h1>复式<br>记账法</h1>
                    </div>
                    <div class="col-xs-7 col-sm-7 placeholder">
                        <input type="month" name="inOut_month" maxlength="7" value="2015-06" placeholder="YYYY-MM" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="column">日期</th>
                                    <th scope="column">序号</th>
                                    <th scope="column">描述</th>
                                    <th scope="column">科目</th>
                                    <th scope="column">借方</th>
                                    <th scope="column">贷方</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- 一天借贷记录 start -->
       
                            <table class="table {{value.tableCss}}">
                                <tbody>
                                    <tr class="one_ent_st">
                                        <th scope="row">2015-1-3</th>
                                        <td rowspan="2">1</td>
                                        <td rowspan="2">交房租</td>
                                        <td>生活费</td>
                                        <td>&yen;9000</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td>中国银行卡</td>
                                        <td></td>
                                        <td>&yen;9000</td>
                                    </tr>
                                </tbody>
                            </table>

                        <!-- 一天借贷记录 end -->
                    </div>
                </div>
            </div>
    </div>

</body>

</html>