<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" href="css/common.css" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<title>鴻鵠塾　学生カルテ</title>
<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>
<![endif]-->
</head>
<body>
<div id="top">
   <div id="header">
     <h1><a href="index.html">鴻鵠塾　学生カルテ</a></h1>
      <div id="pr">
         <p>Test site ver.001</p>
      <!-- /#pr --></div>
   <!-- /#header --></div>
   <div id="menu">
      <ul>
         <li><a href="index.html" class="active">メニュー1</a></li>
         <li><a href="index.html">メニュー2</a></li>
         <li><a href="index.html">メニュー3</a></li>
         <li><a href="index.html">メニュー4</a></li>
         <li><a href="index.html">メニュー5</a></li>
      </ul>
   </div>
   <div id="topicPath">
      <a href="index.html">ホーム</a> &raquo; カテゴリ &raquo; 入力画面
   <!-- /#topicPath --></div>
   <div id="contents">
      <div id="main">
         <h2>ALL DATA</h2>
<?php
require_once('config.php');
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
//$link = mysql_connect('localhost', 'root', 'Acdc4me');
if (!$link) {
    die('接続失敗です。'.mysql_error());
}
$db_selected = mysql_select_db(DB_NAME, $link);
if (!$db_selected){
    die('データベース選択失敗です。'.mysql_error());
}
//print('<p>追加後のデータを取得,表示します。</p>');
$result = mysql_query('SELECT id,name,univ,grade,intervwr  FROM info');
if (!$result) {
    die('SELECTクエリーが失敗しました。'.mysql_error());
}
echo "<table>";
echo " <tr><th>名前</th>
    <th>大学</th>
    <th>学年</th>
    <th>面接官</th></tr>";


while ($row = mysql_fetch_assoc($result)) {
echo "  <tr><td>$row[name]</td>
    <td>$row[univ]</td>
    <td>$row[grade]</td>
    <td>$row[intervwr]</td></tr>";

}
echo "</table>";

 
?>
      <!-- /#main --></div>
 <!-- /#side and bottom menue --><<?php include 'side_bottom.html'; ?>
</body>
</html>
