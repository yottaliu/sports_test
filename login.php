<?php
session_start();

//注销登录
if($_GET['action'] == "logout"){
	unset($_SESSION['classid']);
	unset($_SESSION['username']);
	unset($_SESSION['usertype']);
	echo '注销登录成功！点击此处 <a href="login.html">登录</a>';
	exit;
}

//登录
if(!isset($_POST['submit'])){
	exit('非法访问!');
}
$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$usertype = htmlspecialchars($_POST['usertype']);

//1. 链接数据库
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='student';    //使用的数据库
$user='admin_student';      //数据库连接用户名
$pass='admin_student';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";

try {
    $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    echo "连接成功<br/>";
    /*
    foreach ($dbh->query("SELECT password FROM user WHERE username='{$username}'") as $row) {
        //print_r($row); //你可以用 echo($GLOBAL); 来看到这些值
        echo "{$row['password']}";
    }
    */

    /*
    $check_query = $dbh->query("select type from user where username='$username' and password='$password' limit 1");
    if ($result = $check_query->fetch()) {
        print_r($result);
    }
    */

    if ($usertype == '学生') {
        $sql = "SELECT classid FROM info WHERE no='$username' AND id='$password' LIMIT 1;";
    } else {
        $sql = "SELECT classid FROM user WHERE username='$username' AND type='$usertype' AND password='$password' LIMIT 1;";
    }

    //检测用户名及密码是否正确
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $stmt = $dbh->prepare($sql);
    //$stmt->bindParam(':country', $country, PDO::PARAM_STR);
    $stmt->execute();
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //登录成功
        //print_r($row);
        $_SESSION['classid'] = $row['classid'];
        $_SESSION['username'] = $username;
        $_SESSION['usertype'] = $usertype;
        $dbh = null;
        echo $username,' 欢迎你！';
        echo "你是{$usertype}，";
        echo '进入 <a href="menu.php">用户中心</a><br />';
        echo '点击此处 <a href="login.php?action=logout">注销</a> 登录！<br />';
        exit;
    } else {
        exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
    }
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
//默认不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
//$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
?>
