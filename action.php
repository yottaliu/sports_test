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
//echo $username;
//echo $usertype;
//echo $classid;

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
        switch ($_GET['action']) {
        case 'add_user':
            $count = count($_POST['username_arr']);
            // 这是无序执行
            $sql_insert_user = "INSERT INTO user (username, password, type, classid) VALUES (:username, :password, :type, :classid);";
            $stmt_insert_user = $dbh->prepare($sql_insert_user);
            for ($i = 0; $i < $count; ++$i) {
                // 无序执行第二步
                $stmt_insert_user->execute(array(":username"=>$_POST['username_arr'][$i],
                                                ":password"=>$_POST['password_arr'][$i],
                                                ":type"=>$_POST['type_arr'][$i],
                                                ":classid"=>$_POST['classid_arr'][$i]));
            }
            echo "<script>alter('添加成功');</script>";
            header("Location:user.php");
            break;
        case 'delete_user':
            //echo $_GET['username'];
            //echo $_GET['type'];
            $user = $_GET['username'];
            $type = $_GET['type'];
            $sql_delete_user = "DELETE FROM user WHERE username='$user' AND type='$type';";
            $stmt_delete_user = $dbh->prepare($sql_delete_user);
            $stmt_delete_user->execute();
            echo "<script>alter('删除成功');</script>";
            header("Location:user.php");
            break;
        case 'add_class':
            $count = count($_POST['classid_arr']);
            // 这是无序执行
            $sql_insert_class = "INSERT INTO class (classid, gradeid, classname) VALUES (:classid, :gradeid, :classname);";
            $stmt_insert_class = $dbh->prepare($sql_insert_class);
            for ($i = 0; $i < $count; ++$i) {
                // 无序执行第二步
                $stmt_insert_class->execute(array(":classid"=>$_POST['classid_arr'][$i],
                                                ":gradeid"=>$_POST['gradeid_arr'][$i],
                                                ":classname"=>$_POST['classname_arr'][$i]));
            }
            echo "<script>alter('添加成功');</script>";
            header("Location:class.php");
            break;
        case 'delete_class':
            //echo $_GET['classid'];
            $class = $_GET['classid'];
            $sql_delete_class = "DELETE FROM class WHERE classid='$class';";
            $stmt_delete_class = $dbh->prepare($sql_delete_class);
            $stmt_delete_class->execute();
            echo "<script>alter('删除成功');</script>";
            header("Location:class.php");
            break;
        case 'update_password':
            $password = $_POST['password'];
            $sql_update_password = "UPDATE user SET password='$password' WHERE username='$username' AND type='$usertype';";
            $stmt_update_password = $dbh->prepare($sql_update_password);
            $stmt_update_password->execute();
            echo '修改成功！点击此处<a href="menu.php">返回</a><br />';
            break;
        case 'create_default_teacher':
            $sql_insert_teacher = "INSERT INTO user (username, password, type, classid) SELECT classname, classname, '素质导师', classid FROM class;";
            $stmt_insert_teacher = $dbh->prepare($sql_insert_teacher);
            $stmt_insert_teacher->execute();
            echo '成功！点击此处<a href="user.php">返回</a><br />';
            break;
        case 'create_default_typer':
            $sql_insert_typer = "INSERT INTO user (username, password, type, classid) SELECT classname, classid, '录入人员', classid FROM class;";
            $stmt_insert_typer = $dbh->prepare($sql_insert_typer);
            $stmt_insert_typer->execute();
            echo '成功！点击此处<a href="user.php">返回</a><br />';
            break;
        case 'export_excel':
            $filename = date('Y-m-d-H-i-s').".xls";
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/vnd.ms-execl");
            header("Content-Type: application/force-download");
            header("Content-Type: application/download");
            header("Content-Disposition: attachment; filename=".$filename);
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");
            // 从数据库中获取数据，为了节省内存，不要把数据一次性读到内存，从句柄中一行一行读即可
            $sql_select_info = "SELECT gradeid, class.classid, classname, info.no, nationid, name, sex, birthday, zipcode, id, address FROM info, class WHERE info.classid=class.classid ORDER BY class.gradeid ASC, class.classid ASC, info.no ASC;";
            $sql_select_score = "SELECT info.no, height, weight, fvc, shortrunning, jump, sitandreach, longrunning, pulluporsitup, lefteye, righteye FROM info, score WHERE info.no=score.no ORDER BY info.no ASC;";
            $stmt_select_info = $dbh->prepare($sql_select_info);
            $stmt_select_score = $dbh->prepare($sql_select_score);
            $stmt_select_info->execute();
            $stmt_select_score->execute();
            $th = array("年级编号", "班级编号", "班级名称", "学号", "民族编号", "姓名", "性别", "出生日期", "学生来源", "身份证号", "家庭住址", "身高", "体重", "肺活量", "50米跑", "立定跳远", "坐位体前屈", "1000/800米跑", "引体向上/仰卧起坐", "左眼视力", "右眼视力");
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
                        xmlns:x="urn:schemas-microsoft-com:office:excel"
                        xmlns="http://www.w3.org/TR/REC-html40">
                    <head>
                        <meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">
                        <meta http-equiv=Content-Type content="text/html; charset=gbk">
                        <!--[if gte mso 9]><xml>
                        <x:ExcelWorkbook>
                        <x:ExcelWorksheets>
                        <x:ExcelWorksheet>
                            <x:Name></x:Name>
                            <x:WorksheetOptions>
                                <x:DisplayGridlines/>
                            </x:WorksheetOptions>
                        </x:ExcelWorksheet>
                        </x:ExcelWorksheets>
                        </x:ExcelWorkbook>
                        </xml><![endif]-->
                    </head>';
            echo "<table>";
            echo "<tr>";
            foreach ($th as $i => $v) {
                $th[$i] = iconv('utf-8', 'gbk', $v);
                echo "<th>".$th[$i]."</th>";
            }
            echo "</tr>";
            do {
                $row_select_score = $stmt_select_score->fetch(PDO::FETCH_ASSOC);
                foreach ($row_select_score as $i => $v) {
                    $row_select_score[$i] = iconv('utf-8', 'gbk', $v);
                }
                while ($row_select_info = $stmt_select_info->fetch(PDO::FETCH_ASSOC)) {
                    foreach ($row_select_info as $i => $v) {
                        $row_select_info[$i] = iconv('utf-8', 'gbk', $v);
                    }
                    /*
                    常用的一些格式：
                    1） 文本：vnd.ms-excel.numberformat:@
                    2） 日期：vnd.ms-excel.numberformat:yyyy/mm/dd
                    3） 数字：vnd.ms-excel.numberformat:#,##0.00
                    4） 货币：vnd.ms-excel.numberformat:￥#,##0.00
                    5） 百分比：vnd.ms-excel.numberformat: #0.00%
                    这些格式也可以自定义，比如年月你可以定义为：yy-mm等等。

                    怎么去把这些格式添加到cell中呢？很简单，我们只需要把样式添 加到对应的标签对（即闭合标签）即可。如<td></td>，给标签对<td></td>添加样式，如 下： <td  style="vnd.ms-excel.numberformat:@">410522198402161833</td>
                    同样，也可以给<div></div>添加样式，也可以给<tr>< /tr>，<table></table>添加样式;
                    当在父标签对和子标签对都添加样式时，数据会以哪一个样式呈现 呢？
                    经过测试，会以离数据最近的样式呈现。
                    */
                    echo <<<LABEL
                    <tr>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['gradeid']}</td>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['classid']}</td>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['classname']}</td>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['no']}</td>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['nationid']}</td>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['name']}</td>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['sex']}</td>
                    <td style="vnd.ms-excel.numberformat:yyyy-mm-dd">{$row_select_info['birthday']}</td>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['zipcode']}</td>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['id']}</td>
                    <td style="vnd.ms-excel.numberformat:@">{$row_select_info['address']}</td>
LABEL;
                    if ($row_select_info['no'] == $row_select_score['no']) {
                        echo <<<LABEL
                        <td style="vnd.ms-excel.numberformat:@">{$row_select_score['height']}</td>
                        <td style="vnd.ms-excel.numberformat:@">{$row_select_score['weight']}</td>
                        <td style="vnd.ms-excel.numberformat:@">{$row_select_score['fvc']}</td>
                        <td style="vnd.ms-excel.numberformat:@">{$row_select_score['shortrunning']}</td>
                        <td style="vnd.ms-excel.numberformat:@">{$row_select_score['jump']}</td>
                        <td style="vnd.ms-excel.numberformat:@">{$row_select_score['sitandreach']}</td>
                        <td style="vnd.ms-excel.numberformat:m\'s\'\'">{$row_select_score['longrunning']}</td>
                        <td style="vnd.ms-excel.numberformat:@">{$row_select_score['pulluporsitup']}</td>
                        <td style="vnd.ms-excel.numberformat:@">{$row_select_score['lefteye']}</td>
                        <td style="vnd.ms-excel.numberformat:@">{$row_select_score['righteye']}</td>
                        </tr>
LABEL;
                        break;
                    } else {
                        echo    '</tr>';
                    }
                }
            } while ($row_select_score);
            echo "</table>";
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
            $count = count($_POST['no_arr']);
            // 这是无序执行
            $sql_insert_info = "INSERT INTO info (no, nationid, name, sex, birthday, zipcode, id, address, classid) VALUES (:no, :nationid, :name, :sex, :birthday, :zipcode, :id, :address, :classid);";
            $stmt_insert_info = $dbh->prepare($sql_insert_info);
            for ($i = 0; $i < $count; ++$i) {
                // 无序执行第二步
                $stmt_insert_info->execute(array(":no"=>$_POST['no_arr'][$i],
                                                ":nationid"=>$_POST['nationid_arr'][$i],
                                                ":name"=>$_POST['name_arr'][$i],
                                                ":sex"=>$_POST['sex_arr'][$i],
                                                ":birthday"=>$_POST['birthday_arr'][$i],
                                                ":zipcode"=>$_POST['zipcode_arr'][$i],
                                                ":id"=>$_POST['id_arr'][$i],
                                                ":address"=>$_POST['address_arr'][$i],
                                                ":classid"=>$classid));
            }
            echo "<script>alter('添加成功');</script>";
            header("Location:check.php");
            break;
        case 'delete_student':
            //echo $_GET['no'];
            $no = $_GET['no'];
            $sql_delete_score = "DELETE FROM score WHERE no='$no';";
            $sql_delete_info = "DELETE FROM info WHERE no='$no';";
            $stmt_delete_score = $dbh->prepare($sql_delete_score);
            $stmt_delete_info = $dbh->prepare($sql_delete_info);
            $stmt_delete_score->execute();
            $stmt_delete_info->execute();
            echo "<script>alter('删除成功');</script>";
            header("Location:check.php");
            break;
        case 'alter_info':
            $count = count($_SESSION['no_arr']);
            // 这是有序执行
            $sql_update_info = "UPDATE info SET nationid=?, name=?, sex=?, birthday=?, zipcode=?, id=?, address=? WHERE no=?;";
            $stmt_update_info = $dbh->prepare($sql_update_info);
            for ($i = 0; $i < $count; ++$i) {
                // 有序执行第二步
                $stmt_update_info->execute(array($_POST['nationid_arr'][$i],
                                                $_POST['name_arr'][$i],
                                                $_POST['sex_arr'][$i],
                                                $_POST['birthday_arr'][$i],
                                                $_POST['zipcode_arr'][$i],
                                                $_POST['id_arr'][$i],
                                                $_POST['address_arr'][$i],
                                                $_SESSION['no_arr'][$i]));
            }
            unset($_SESSION['no_arr']);
            echo '修改成功！点击此处<a href="check.php">返回</a><br />';
            break;
        case 'update_password':
            $password = $_POST['password'];
            $sql_update_password = "UPDATE user SET password='$password' WHERE username='$username' AND type='$usertype';";
            $stmt_update_password = $dbh->prepare($sql_update_password);
            $stmt_update_password->execute();
            echo '修改成功！点击此处<a href="check.php">返回</a><br />';
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
            $count = count($_SESSION['no_arr']);
            // 这是无序执行
            $sql_update_score = "UPDATE score SET height=:height, weight=:weight, fvc=:fvc, shortrunning=:shortrunning, jump=:jump, sitandreach=:sitandreach, longrunning=:longrunning, pulluporsitup=:pulluporsitup, lefteye=:lefteye, righteye=:righteye WHERE no=:no;";
            $sql_insert_score = "INSERT INTO score (height, weight, fvc, shortrunning, jump, sitandreach, longrunning, pulluporsitup, lefteye, righteye, no) VALUES (:height, :weight, :fvc, :shortrunning, :jump, :sitandreach, :longrunning, :pulluporsitup, :lefteye, :righteye, :no);";
            $stmt_update_score = $dbh->prepare($sql_update_score);
            $stmt_insert_score = $dbh->prepare($sql_insert_score);
            for ($i = 0; $i < $count; ++$i) {
                if ($_SESSION['already_exist_arr'][$i] == 1) {
                    $stmt_score = $stmt_update_score;
                } else {
                    $stmt_score = $stmt_insert_score;
                }
                // 无序执行第二步
                $stmt_score->execute(array(":height"=>$_POST['height_arr'][$i],
                                            ":weight"=>$_POST['weight_arr'][$i],
                                            ":fvc"=>$_POST['fvc_arr'][$i],
                                            ":shortrunning"=>$_POST['shortrunning_arr'][$i],
                                            ":jump"=>$_POST['jump_arr'][$i],
                                            ":sitandreach"=>$_POST['sitandreach_arr'][$i],
                                            ":longrunning"=>$_POST['longrunning_arr'][$i],
                                            ":pulluporsitup"=>$_POST['pulluporsitup_arr'][$i],
                                            ":lefteye"=>$_POST['lefteye_arr'][$i],
                                            ":righteye"=>$_POST['righteye_arr'][$i],
                                            ":no"=>$_SESSION['no_arr'][$i]));
            }
            unset($_SESSION['no_arr']);
            unset($_SESSION['already_exist_arr']);
            echo '修改成功！点击此处<a href="check.php">返回</a><br />';
            break;
        default:
            break;
        }
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
