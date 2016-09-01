<th>用户名</th>
<th>类型</th>
<th>班级编号</th>

<?php
function td_show_user($row) {
    echo <<<LABEL
    <td> {$row['username']} </td>
    <td> {$row['type']} </td>
    <td> {$row['classid']} </td>
LABEL;
}

?>
