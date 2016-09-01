<script>
    function do_delete(no) {
        if(confirm('确认删除?')) {
            window.location='action.php?action=delete_student&no='+no;
        }
    }
</script>
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

$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='student';    //使用的数据库

try {
    echo '点击此处 <a href="login.php?action=logout">注销</a> 登录！<br />';
    switch ($usertype) {
    case '管理员':
        $user='admin_student';      //数据库连接用户名
        $pass='admin_student';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        echo "连接成功<br/>";
        $classid = $_GET['classid'];
        $sql_info = "SELECT * FROM info, class WHERE info.classid='$classid' AND info.classid=class.classid ORDER BY info.no ASC;";
        $sql_score = "SELECT * FROM info, score WHERE info.classid='$classid' AND info.no=score.no ORDER BY info.no ASC;";
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt_info = $dbh->prepare($sql_info);
        $stmt_score = $dbh->prepare($sql_score);
        $stmt_info->execute();
        $stmt_score->execute();
        echo '<style>table tr td,th{border:1px solid #000;}</style>';
        echo '<center>';
        echo '<table>';
        echo    '<caption><strong>学生信息</strong></caption>';
        echo    '<tr>';
        include("check_info1.php");
        include("check_info2.php");
        include("check_score.php");
        echo    '</tr>';
        do {
            $row_score = $stmt_score->fetch(PDO::FETCH_ASSOC);
            while ($row_info = $stmt_info->fetch(PDO::FETCH_ASSOC)) {
                echo    '<tr>';
                td_show_info1($row_info);
                td_show_info2($row_info);
                if ($row_info['no'] == $row_score['no']) {
                    td_show_score($row_score);
                } else {
                    td_show_score_empty();
                }
                echo    '</tr>';
                if ($row_info['no'] == $row_score['no']) {
                    break;
                }
            }
        } while ($row_score);
        echo '</table>';
        echo '</center>';
        echo '<a href="javascript:history.back(0);">返回</a><br />';
        break;
    case '素质导师':
        $user='teacher_student';      //数据库连接用户名
        $pass='teacher_student';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        echo "连接成功<br/>";
        $sql_info = "SELECT * FROM info, class WHERE info.classid='$classid' AND info.classid=class.classid ORDER BY info.no ASC;";
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt_info = $dbh->prepare($sql_info);
        $stmt_info->execute();
        echo '<style>table tr td,th{border:1px solid #000;}</style>';
        echo '<center>';
        echo '<table>';
        echo    '<caption><strong>学生信息</strong></caption>';
        echo    '<tr>';
        include("check_info1.php");
        include("check_info2.php");
        echo    '</tr>';
        while ($row_info = $stmt_info->fetch(PDO::FETCH_ASSOC)) {
            echo    '<tr>';
            td_show_info1($row_info);
            td_show_info2($row_info);
            echo "<td><a href='javascript:void(0);' onclick='do_delete({$row_info['no']})'>删除</a></td>";
            echo    '</tr>';
        }
        echo '</table>';
        echo '</center>';
        echo '点击此处 <a href="edit.php?action=alter_info">修改</a><br />';
        echo '点击此处 <a href="add.php?action=add_student">添加</a><br />';
        echo '点击此处 <a href="password.php">更改密码</a><br />';
        break;
    case '录入人员':
        $user='typer_student';      //数据库连接用户名
        $pass='typer_student';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        echo "连接成功<br/>";
        $sql_info = "SELECT * FROM info, class WHERE info.classid='$classid' AND info.classid=class.classid ORDER BY info.no ASC;";
        $sql_score = "SELECT * FROM info, score WHERE info.classid='$classid' AND info.no=score.no ORDER BY info.no ASC;";
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt_info = $dbh->prepare($sql_info);
        $stmt_score = $dbh->prepare($sql_score);
        $stmt_info->execute();
        $stmt_score->execute();
        echo '<style>table tr td,th{border:1px solid #000;}</style>';
        echo '<center>';
        echo '<table>';
        echo    '<caption><strong>学生信息</strong></caption>';
        echo    '<tr>';
        include("check_info1.php");
        include("check_score.php");
        echo    '</tr>';
        do {
            $row_score = $stmt_score->fetch(PDO::FETCH_ASSOC);
            while ($row_info = $stmt_info->fetch(PDO::FETCH_ASSOC)) {
                echo    '<tr>';
                td_show_info1($row_info);
                if ($row_info['no'] == $row_score['no']) {
                    td_show_score($row_score);
                } else {
                    td_show_score_empty();
                }
                echo    '</tr>';
                if ($row_info['no'] == $row_score['no']) {
                    break;
                }
            }
        } while ($row_score);
        echo '</table>';
        echo '</center>';
        echo '点击此处 <a href="edit.php?action=alter_score">修改</a><br />';
        break;
    case '学生':
        $user='student_student';      //数据库连接用户名
        $pass='student_student';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        echo "连接成功<br/>";
        $sql_info = "SELECT * FROM info, class WHERE info.no='$username' AND info.classid=class.classid LIMIT 1;";
        $sql_score = "SELECT * FROM info, score WHERE info.no='$username' AND info.no=score.no LIMIT 1;";
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt_info = $dbh->prepare($sql_info);
        $stmt_score = $dbh->prepare($sql_score);
        $stmt_info->execute();
        $stmt_score->execute();
        echo '<style>table tr td,th{border:1px solid #000;}</style>';
        echo '<center>';
        echo '<table>';
        echo    '<caption><strong>学生信息</strong></caption>';
        echo    '<tr>';
        include("check_info1.php");
        include("check_info2.php");
        include("check_score.php");
        echo    '</tr>';
        if ($row_info = $stmt_info->fetch(PDO::FETCH_ASSOC)) {
            $row_score = $stmt_score->fetch(PDO::FETCH_ASSOC);
            echo    '<tr>';
            td_show_info1($row_info);
            td_show_info2($row_info);
            if ($row_info['no'] == $row_score['no']) {
                td_show_score($row_score);
            } else {
                td_show_score_empty();
            }
            echo    '</tr>';
        }
        echo '</table>';
        echo '</center>';
        break;
    default:
        break;
    }
    $dbh = null;
    exit;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
?>
