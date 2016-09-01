<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['classid'])){
	header("Location:login.html");
	exit();
}

$classid = htmlspecialchars($_SESSION['classid']);          // 暂未使用
$username = htmlspecialchars($_SESSION['username']);        // 本页面未使用
$usertype = htmlspecialchars($_SESSION['usertype']);
echo $username;
echo $usertype;
echo $classid;

switch ($usertype) {
case '管理员':
    echo <<<LABEL
    <center>
        <a href="user.php">用户管理</a><br />
        <a href="class.php">班级管理</a><br />
        <a href="password.php">修改密码</a><br />
        <a href="login.php?action=logout">注销</a><br />
    </center>
LABEL;
    break;
case '素质导师':
    // fall through
case '录入人员':
    // fall through
case '学生':
    header('Location: check.php');
    break;
default:
    break;
}
exit;
?>
