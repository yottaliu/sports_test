<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['classid'])){
	header("Location:login.html");
	exit();
}

$classid = htmlspecialchars($_SESSION['classid']);
$username = htmlspecialchars($_SESSION['username']);
$usertype = htmlspecialchars($_SESSION['usertype']);
echo $username;
echo $usertype;
echo $classid;

//1. 链接数据库
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='student';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wuchangligong';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";

try {
    $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    echo "连接成功<br/>";
    echo '点击此处 <a href="login.php?action=logout">注销</a> 登录！<br />';
    switch ($usertype) {
    case '管理员':
        $sql_user = "SELECT username, type, classid FROM user ORDER BY username ASC;";
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt_user = $dbh->prepare($sql_user);
        $stmt_user->execute();
        echo '<style>table tr td,th{border:1px solid #000;}</style>';
        echo '<center>';
        echo '<table>';
        echo    '<caption><strong>用户信息</strong></caption>';
        echo    '<tr>';
        include("check_user1.php");
        echo    '</tr>';
        while ($row_user = $stmt_user->fetch(PDO::FETCH_ASSOC)) {
            echo    '<tr>';
            td_show_user($row_user);
            echo "<td><a href='action.php?action=delete_user&username={$row_user['username']}&type={$row_user['type']}'>删除</a></td>";
            echo    '</tr>';
        }
        echo '</table>';
        echo '</center>';
        echo '点击此处 <a href="add.php?action=add_user">添加</a> 用户<br />';
        echo '点击此处 <a href="action.php?action=create_default_teacher">生成</a> 默认<strong>素质导师</strong>用户（仅初次使用）<br />';
        echo '点击此处 <a href="action.php?action=create_default_typer">生成</a> 默认<strong>录入人员</strong>用户（仅初次使用）<br />';
        break;
    default:
        break;
    }
    echo '点击此处 <a href="menu.php">返回</a> 用户中心<br />';
    $dbh = null;
    exit;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
?>
