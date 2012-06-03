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

    $email = $_POST['email'];
    $password = $_POST['password'];
    $save = ($_POST['save'] == 1) ? 1 : 0;
    
    // error check
    $err = array();
    if (!checkExistingEmail($email)) $err['email'] = 'そのメールアドレスは登録されていません。';
    if ($email == '') $err['email'] = 'メールアドレスを入力してください。';
    $me = getUser($email, $password);
    if (!$me) $err['password'] = 'メールアドレスかパスワードが正しくありません。';
    if ($password == '') $err['password'] = 'パスワードを入力してください。';
    
    if (empty($err)) {
        // セッションハイジャック対策
        session_regenerate_id(true);
        
        if ($save) {
            setcookie(session_name(), session_id(), time() + 60*60*24*14);
        }
        
        $_SESSION['me'] = $me;
        jump('admin_index.php');
    }
}
?>
<h1>Sign up</h1>
    <form action="" method="post">
    <p>メールアドレス： <input type="text" name="email" value="<?php echo h($email); ?>"> <?php echo $err['email']; ?></p>
    <p>パスワード： <input type="password" name="password" value="<?php echo h($password); ?>"> <?php echo $err['password']; ?></p>
    <p><input type="checkbox" name="save" value="1" <?php if ($save) echo "checked"; ?>> ２週間ログイン情報を保存する</p>
    <p><input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"></p>
    <p><input type="submit" value="ログイン"> <a href="signin.php">新規登録はこちらから！</a></p>
    
    </form>
<!-- /#bottom --><?php include 'bottom.html'; ?>
