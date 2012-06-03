 <!-- /#header --><?php include 'header.html'; ?>
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
    $email = $_POST['email'];
    $writer = $_POST['writer'];
    $comment = $_POST['comment'];

    // error check
    $err = array();
    if ($name == '') $err['name'] = '学生の名前を入力してください。';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $err['email'] = 'メールアドレスを正しくありません。';
    if ($email == '') $err['email'] = 'メールアドレスを入力してください。';
    if ($writer == '') $err['writer'] = '社会人の名前を入力してください。';
    if ($comment == '') $err['comment'] = '社会人の名前を入力してください。';

    if (empty($err)) {
      // DBにデータを入れる
      $q = sprintf("insert into data (name, email, writer, comment) values 
                                       ('%s','%s','%s','%s')",
            r($name),
            r($email),
            r($writer),
            r($comment)
		   );
      $rs = mysql_query($q);
      jump('signup.php');
    }
}
?>
<h1>面接コメント入力画面</h1>
<form action="" method="post">
<p>学生の名前: <input type="text" name="name" value="<?php echo h($name); ?>"></p>
<p>学生のメールアドレス： <input type="text" name="email" value="<?php echo h($email); ?>"> </p>
<p>社会人の名前: <input type="text" name="writer" value="<?php echo h($writer); ?>"></p>
<p>面接のコメント:<textarea name="comment" rows="10" cols="40" value="<?php echo h($comment); ?>"></textarea></P>
<p><input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"></p>
<p><input type="submit" value="登録"></p>
</form>
<!-- /#bottom --><?php include 'bottom.html'; ?>