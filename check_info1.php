<th>班级名称</th>
<th>学号</th>
<th>民族代码</th>
<th>姓名</th>
<th>性别</th>
<?php
function td_show_info1($row) {
    echo <<<LABEL
    <td> {$row['classname']} </td>
    <td> {$row['no']} </td>
    <td> {$row['nationid']} </td>
    <td> {$row['name']} </td>
    <td> {$row['sex']} </td>
LABEL;
}
function td_input_info1($row, $count) {
    echo <<<LABEL
    <td> {$row['classname']} </td>
    <td> {$row['no']} </td>
    <td> <input name='nationid_arr[$count]' type='text' value={$row['nationid']} /> </td>
    <td> <input name='name_arr[$count]' type='text' value={$row['name']} /> </td>
    <td> <input name='sex_arr[$count]' type='text' value={$row['sex']} /> </td>
LABEL;
}

function td_input_info1_empty($row, $count) {
    echo <<<LABEL
    <td> {$row['classname']} </td>
    <td> <input name='no_arr[$count]' type='text' /> </td>
    <td> <input name='nationid_arr[$count]' type='text' /> </td>
    <td> <input name='name_arr[$count]' type='text' /> </td>
    <td> <input name='sex_arr[$count]' type='text' /> </td>
LABEL;
}

?>
