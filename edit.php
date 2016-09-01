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

$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='student';    //使用的数据库

try {
    switch ($usertype) {
    case '管理员':
        $user='admin_student';      //数据库连接用户名
        $pass='admin_student';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        echo "连接成功<br/>";

        switch ($_GET['action']) {
        case 'add_user':
            $num = $_POST['num'];
            echo $num;
            echo '<style>table tr td,th{border:1px solid #000;}</style>';
            echo "<form method='post' action='action.php?action=add_user'>";
            echo '<table>';
            echo    '<caption><strong>用户信息</strong></caption>';
            echo    '<tr>';
            include("check_user2.php");
            echo    '</tr>';
            for ($i = 0; $i < $num; ++$i) {
                echo    '<tr>';
                td_input_user2_empty($i);
                echo    '</tr>';
            }
            echo '</table>';
            echo '<input type="submit" value="提交" /><br />';
            echo '</form>';
            break;
        case 'add_class':
            $num = $_POST['num'];
            echo $num;
            echo '<style>table tr td,th{border:1px solid #000;}</style>';
            echo "<form method='post' action='action.php?action=add_class'>";
            echo '<table>';
            echo    '<caption><strong>班级信息</strong></caption>';
            echo    '<tr>';
            include("check_class.php");
            echo    '</tr>';
            for ($i = 0; $i < $num; ++$i) {
                echo    '<tr>';
                td_input_class_empty($i);
                echo    '</tr>';
            }
            echo '</table>';
            echo '<input type="submit" value="提交" /><br />';
            echo '</form>';
            break;
        default:
            break;
        }
        break;
    case '素质导师':
        $user='teacher_student';      //数据库连接用户名
        $pass='teacher_student';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        echo "连接成功<br/>";

        switch ($_GET['action']) {
        case 'add_student':
            $num = $_POST['num'];
            echo $num;
            $sql_classname = "SELECT classname FROM class WHERE classid='$classid' LIMIT 1;";
            $stmt_classname = $dbh->prepare($sql_classname);
            $stmt_classname->execute();
            echo '<style>table tr td,th{border:1px solid #000;}</style>';
            echo "<form method='post' action='action.php?action=add_student'>";
            echo '<table>';
            echo    '<caption><strong>学生信息</strong></caption>';
            echo    '<tr>';
            include("check_info1.php");
            include("check_info2.php");
            echo    '</tr>';
            $row_classname = $stmt_classname->fetch(PDO::FETCH_ASSOC);
            for ($i = 0; $i < $num; ++$i) {
                echo    '<tr>';
                td_input_info1_empty($row_classname, $i);
                td_input_info2_empty($i);
                echo    '</tr>';
            }
            echo '</table>';
            echo '<input type="submit" value="提交" /><br />';
            echo '</form>';
            break;
        case 'alter_info':
            $sql_info = "SELECT * FROM info, class WHERE info.classid='$classid' AND info.classid=class.classid ORDER BY info.no ASC;";
            $sql_score = "SELECT * FROM info, score WHERE info.classid='$classid' AND info.no=score.no ORDER BY info.no ASC;";
            $stmt_info = $dbh->prepare($sql_info);
            $stmt_score = $dbh->prepare($sql_score);
            $rw = $stmt_info->execute();
            $stmt_score->execute();
            $count = 0;
            echo '<style>table tr td,th{border:1px solid #000;}</style>';
            echo "<form method='post' action='action.php?action=alter_info'>";
            echo '<table>';
            echo    '<caption><strong>学生信息</strong></caption>';
            echo    '<tr>';
            include("check_info1.php");
            include("check_info2.php");
            echo    '</tr>';
            while ($row_info = $stmt_info->fetch(PDO::FETCH_ASSOC)) {
                echo    '<tr>';
                td_input_info1($row_info, $count);
                td_input_info2($row_info, $count);
                echo    '</tr>';
                $_SESSION['no_arr'][$count] = $row_info['no'];
                ++$count;
            }
            echo '</table>';
            echo '<input type="submit" value="提交" /><br />';
            echo '</form>';
            break;
        default:
            break;
        }
        break;
    case '录入人员':
        $user='typer_student';      //数据库连接用户名
        $pass='typer_student';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        echo "连接成功<br/>";

        switch ($_GET['action']) {
        case 'alter_score':
            $sql_info = "SELECT * FROM info, class WHERE info.classid='$classid' AND info.classid=class.classid ORDER BY info.no ASC;";
            $sql_score = "SELECT * FROM info, score WHERE info.classid='$classid' AND info.no=score.no ORDER BY info.no ASC;";
            $stmt_info = $dbh->prepare($sql_info);
            $stmt_score = $dbh->prepare($sql_score);
            $rw = $stmt_info->execute();
            $stmt_score->execute();
            $count = 0;
            echo '<style>table tr td,th{border:1px solid #000;}</style>';
            echo "<form method='post' action='action.php?action=alter_score'>";
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
                        td_input_score($row_score, $count);
                    } else {
                        td_input_score_empty($count);
                    }
                    echo    '</tr>';
                    $_SESSION['no_arr'][$count] = $row_info['no'];
                    ++$count;
                    if ($row_info['no'] == $row_score['no']) {
                        $_SESSION['already_exist_arr'][$count - 1] = 1;
                        break;
                    } else {
                        $_SESSION['already_exist_arr'][$count - 1] = 0;
                    }
                }
            } while ($row_score);
            echo '</table>';
            echo '<input type="submit" value="提交" /><br />';
            echo '</form>';
            break;
        default:
            break;
        }
        break;
    default:
        break;
    }
    $dbh = null;
    echo '<a href="javascript:history.back(0);">返回</a><br />';
    exit;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
?>
