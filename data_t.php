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
         <h2>入力ありがとうございました。</h2>

<?php
require_once('config.php');
require_once('functions.php');
// CSRF対策

session_start();

if ($_SERVER['REQUEST_METHOD']!='POST') {
    setToken();
} else {
    checkToken();
    
    // DB接続
    connectDb();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $univ = $_POST['univ'];
    $grade = $_POST['grade'];
    $intervwr = $_POST['intervwr'];

print($_POST['name'].  'さん');
   // error check
    $err = array();
    if ($name == '') $err['name'] = 'お名前を入力してください。';
    if ($univ == '') $err['univ'] = '大学名を入力してください。';
    if ($grade == '') $err['grade'] = '学年を入力してください。';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $err['email'] = 'メールアドレスを正しくありません。';
    if (checkExistingEmail($email)) $err['email'] = 'このメールアドレスはすでに登録されています。';
    if ($email == '') $err['email'] = 'メールアドレスを入力してください。';
    if ($password == '') $err['password'] = 'パスワードを入力してください。';
    
    if (empty($err)) {
        // DBにデータを入れる
        $sha1password = getSha1Password($password);
        $q = sprintf("insert into info (name, email, password, univ, grade, intervwr) values 
                                       ('%s','%s','%s','%s','%d','%s')",
            r($name),
            r($email),
            $sha1password,
            r($univ),
            r($grade),
            r($intervwr));
        $rs = mysql_query($q);
        jump('login.php');
    }
}
?>

<form action="" method="post">
<p> お名前: <input type="text" name="name"></p>
<p> 大学: <input type="text" name="univ"></p>
<p> 学年: <input type="text" name="grade"></p>
<p> 面接してくれた社会人: 
  <select type="text" name="intervwr" size="1">
        <option value="上田">上田さん</option>
        <option value="松村">松村さん</option>
        <option value="赤木">赤木さん</option>
        <option value="谷内">谷内さん</option>
    </select>
</p>
<p> パスワード: <input type="text" name="password"></p>
<p> e-mail: <input type="text" name="email"></p>
 <p><input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"></p>
    <p><input type="submit" value="登録！"></p>
</form>

<p>右側のメニュー > すべてのデータ　で今まで送られたデータを見ることができます。</p>
      <!-- /#main --></div>
 <!-- /#side and bottom menue --><<?php include 'side_bottom.html'; ?>
</body>
</html>
