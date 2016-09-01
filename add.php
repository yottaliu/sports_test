<script language=JavaScript>
<!--

function InputCheck(EditForm)
{
    var re = /^[0-9]*[1-9][0-9]*$/;
    if (!re.test(EditForm.num.value)) {
        alert("请输入一个正整数!");
        EditForm.num.focus();
        return (false);
    }
}

//-->
</script>

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
    switch ($_GET['action']) {
    case 'add_user':
        echo "<form method='post' action='edit.php?action=add_user' name='EditForm' onSubmit='return InputCheck(this)'>";
        echo '<label for="num">请输入添加用户的数量：</label>';
        echo '<input name="num" id="num" type="text" value="1" /><br />';
        echo '<input type="submit" value="确认" /><br />';
        echo '</form>';
        break;
    case 'add_class':
        echo "<form method='post' action='edit.php?action=add_class' name='EditForm' onSubmit='return InputCheck(this)'>";
        echo '<label for="num">请输入添加班级的数量：</label>';
        echo '<input name="num" id="num" type="text" value="1" /><br />';
        echo '<input type="submit" value="确认" /><br />';
        echo '</form>';
        break;
    default:
        break;
    }
    break;
case '素质导师':
    switch ($_GET['action']) {
    case 'add_student':
        echo "<form method='post' action='edit.php?action=add_student' name='EditForm' onSubmit='return InputCheck(this)'>";
        echo '<label for="num">请输入添加学生的数量：</label>';
        echo '<input name="num" id="num" type="text" value="1" /><br />';
        echo '<input type="submit" value="确认" /><br />';
        echo '</form>';
        break;
    default:
        break;
    }
default:
    break;
}
echo '<a href="javascript:history.back(0);">返回</a><br />';
exit;
?>
