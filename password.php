<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>修改密码</title>
  <style type="text/css">
    html{font-size:12px;}
	fieldset{width:520px; margin: 0 auto;}
	legend{font-weight:bold; font-size:14px;}
	label{float:left; width:70px; margin-left:10px;}
	.left{margin-left:80px;}
	.input{width:150px;}
	span{color: #666666;}
  </style>
<script language=JavaScript>
<!--

function InputCheck(PasswordForm)
{
    if (PasswordForm.password.value == "")
    {
        alert("必须设定登陆密码!");
        PasswordForm.password.focus();
        return (false);
    }
    if (PasswordForm.repass.value != PasswordForm.password.value)
    {
        alert("两次密码不一致!");
        PasswordForm.repass.focus();
        return (false);
    }
}

//-->
</script>
</head>

<body>
<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['classid'])){
	header("Location:login.html");
	exit();
}

$classid = htmlspecialchars($_SESSION['classid']);
$username = htmlspecialchars($_SESSION['username']);    // 本页面未使用
$usertype = htmlspecialchars($_SESSION['usertype']);
echo $username;
echo $usertype;
echo $classid;

switch ($usertype) {
case '管理员':
    // fall through
case '素质导师':
    echo <<<LABEL
    <div>
    <fieldset>
        <legend>修改密码</legend>
        <form name="PasswordForm" method="post" action="action.php?action=update_password" onSubmit="return InputCheck(this)">
            <p>
            <label for="password" class="label">新 密 码 ：</label>
            <input id="password" name="password" type="password" class="input" />
            <span>(必填，不得少于6位)</span>
            <p/>

            <p>
            <label for="repass" class="label">重复密码：</label>
            <input id="repass" name="repass" type="password" class="input" />
            <span>(必填，验证新密码)</span>
            <p/>

            <p>
            <input type="submit" name="submit" value="  确认  " class="left" />
            </p>
        </form>
    </fieldset>
    </div>
LABEL;
    break;
default:
    break;
}
echo '<a href="javascript:history.back(0);">返回</a><br />';
exit;
?>
</body>
</html>
