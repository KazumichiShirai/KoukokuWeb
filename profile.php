<!-- /#header --><?php include 'header.html'; ?>
<?php
require_once('config.php');
require_once('functions.php');
session_start();
connectDb();

$bid = base64_decode($_GET['id']);
/* $q = sprintf("select * from info where id=%d limit 1", r($_GET['id'])); */
$q = sprintf("select * from info where id=%d limit 1", r($bid));
$rs = mysql_query($q);
if (!mysql_num_rows($rs)) {
  echo "Not Found！";
  exit;
}
$user = mysql_fetch_assoc($rs);

?>
<head>
    <title>ユーザープロフィール</title>
</head>
<body>
    <h1>ユーザープロフィール</h1>
  <p>お名前：<?php echo h($user['name']); ?></p>
  <p>メールアドレス：<?php echo h($user['email']); ?></p>
    <p><a href="index.php">ホームヘ</a></p>
</body>
<!-- /#bottom --><?php include 'bottom.html'; ?>