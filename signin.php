 <!-- /#header --><?php include 'header_n.html'; ?>
<?php
require_once('config.php');
require_once('functions.php');
session_start();
if ($_SERVER['REQUEST_METHOD']!='POST') {
    setToken();
} else {
  checkToken();
    // DB接続
    connectDb();
    $name = $_POST['name'];
    $univ = $_POST['univ'];
    $grade = $_POST['grade'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
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
      $q = sprintf("insert into info (name, email, password, univ, grade) values 
                                       ('%s','%s','%s','%s','%d')",
            r($name),
            r($email),
            $sha1password,
            r($univ),
            r($grade)
		   );
      $rs = mysql_query($q);
      jump('signup.php');
    }
}
?>
<header class="jumbotron subhead" id="overview">
  <h1>Sign in</h1>
  <p class="lead">ユーザ登録画面</p>
</header>

<div class="row">
<div class="span4">
<div class="page-header">
<h1>学生</h1><!-- /.学生登録 -->
</div>
<form action="" method="post">
</i> お名前: <input type="text" name="name" value="<?php echo h($name); ?>">
<p> 大学: <input type="text" name="univ" value="<?php echo h($univ); ?>"></p>
<p> 学年: <input type="text" name="grade" value="<?php echo h($grade); ?>"></p>
<p>メールアドレス： <input type="text" name="email" value="<?php echo h($email); ?>"> </p>
<p>パスワード： <input type="password" name="password" value="<?php echo h($password); ?>"></p>
<p><input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"></p>
<p><input type="submit" value="登録"></p>
</form>
</div><!-- /.span -->
<div class="span4">
<div class="page-header">
<h1>社会人</h1><!-- /.社会人登録 -->
</div>
<form action="" method="post">
</i> お名前: <input type="text" name="name" value="<?php echo h($name); ?>">
<input type="hidden" name="univ" value="社会人">
<input type="hidden" name="grade" value="<?php echo ADULT_NUM; ?>">
<p>メールアドレス： <input type="text" name="email" value="<?php echo h($email); ?>"> </p>
<p>パスワード： <input type="password" name="password" value="<?php echo h($password); ?>"></p>
<p><input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"></p>
<p><input type="submit" value="登録"></p>
</form>
</div><!-- /.span -->
</div><!-- /.row -->
</header>
<!-- /#bottom --><?php include 'bottom.html'; ?>
