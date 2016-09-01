<th>年级编号</th>
<th>班级编号</th>
<th>班级名称</th>

<?php
function td_show_class($row) {
    echo <<<LABEL
    <td> {$row['gradeid']} </td>
    <td> {$row['classid']} </td>
    <td> {$row['classname']} </td>
LABEL;
}

function td_input_class_empty($count) {
    echo <<<LABEL
    <td> <input name='gradeid_arr[$count]' type='text' /> </td>
    <td> <input name='classid_arr[$count]' type='text' /> </td>
    <td> <input name='classname_arr[$count]' type='text' /> </td>
LABEL;
}

?>
