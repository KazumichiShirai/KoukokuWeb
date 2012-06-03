<!-- /#header --><?php include 'header.html'; ?>
<?php
require_once('config.php');
require_once('functions.php');
session_start();
connectDb();

$me = $_SESSION['me'];

$info = array();

$q = "select * from info order by id desc";
$rs = mysql_query($q);
while ($row = mysql_fetch_assoc($rs)) {
  array_push($info, $row);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム画面</title>
</head>
<body>
    <h1>ホーム</h1>
  <p>お名前：<?php echo h($me['name']); ?></p>
  <p>メールアドレス：<?php echo h($me['email']); ?></p>
    <h2>全ユーザー一覧</h2>
    <ul>
<?php foreach ($info as $user) : ?>
<?php $bid = base64_encode($user['id']); ?>
<!--  <li><a href="profile.php?id=<?php echo $user['id']; ?>"><?php echo h($user['name']); ?></a></li> -->
<li><a href="profile.php?id=<?php echo $bid; ?>"><?php echo h($user['name']); ?></a></li>
<?php endforeach; ?>
    </ul>
</body>
<!-- /#bottom --><?php include 'bottom.html'; ?>