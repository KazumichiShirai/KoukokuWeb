<?php

function connectDb() {
    mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("can't connect to DB:".mysql_error());
    mysql_select_db(DB_NAME) or die("can't select DB:".mysql_error());
}

function h($s) {
    return htmlspecialchars($s);
}

function r($s) {
    return mysql_real_escape_string($s);
}

function checkExistingEmail($email) {
    $q = sprintf("select * from info where email = '%s' limit 1", r($email));
    $rs = mysql_query($q);
    return (mysql_num_rows($rs) ? true : false);
}

function getSha1Password($s) {
    return (sha1(PASSWORD_KEY.$s));
}

function jump($s) {
    header('Location: '.SITE_URL.$s);
    exit;
}

function setToken() {
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
}

function checkToken() {
    if ($_SESSION['token'] != $_POST['token']) {
        echo "不正なPOSTが行われました";
        exit;
    }
}

function getUser($email, $password) {
    $sha1password = getSha1Password($password);
    $q = sprintf("select * from info where email = '%s' and password = '%s' limit 1", 
        r($email),
        $sha1password);
    $rs = mysql_query($q);
    $row = mysql_fetch_assoc($rs);
    return ($row ? $row : false);
}

function checkLogin() {
    if (empty($_SESSION['me'])) {
        jump('login.php');
    }
}
