<script>
    function do_delete(classid) {
        if(confirm('确认为空后再删除，确认?')) {
            window.location='action.php?action=delete_class&classid='+classid;
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
        $sql_class = "SELECT * FROM class ORDER BY gradeid ASC, classid ASC;";
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt_class = $dbh->prepare($sql_class);
        $stmt_class->execute();
        echo '<style>table tr td,th{border:1px solid #000;}</style>';
        echo '<center>';
        echo '<table>';
        echo    '<caption><strong>班级信息</strong></caption>';
        echo    '<tr>';
        include("check_class.php");
        echo    '</tr>';
        while ($row_class = $stmt_class->fetch(PDO::FETCH_ASSOC)) {
            echo    '<tr>';
            td_show_class($row_class);
            echo "<td><a href='check.php?classid={$row_class['classid']}'>查看</a></td>";
            echo "<td><a href='javascript:void(0);' onclick='do_delete({$row_class['classid']})'>删除</a></td>";
            echo    '</tr>';
        }
        echo '</table>';
        echo '</center>';
        echo '点击此处 <a href="add.php?action=add_class">添加</a> 班级<br />';
        echo '点击此处 <a href="action.php?action=export_excel">导出</a> 为Excel<br />';
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
