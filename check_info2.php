<th>出生日期</th>
<th>学生来源</th>
<th>身份证号</th>
<th>家庭住址</th>

<?php
function td_show_info2($row) {
    echo <<<LABEL
    <td> {$row['birthday']} </td>
    <td> {$row['zipcode']} </td>
    <td> {$row['id']} </td>
    <td> {$row['address']} </td>
LABEL;
}

function td_input_info2($row, $count) {
    echo <<<LABEL
    <td> <input name='birthday_arr[$count]' type='text' value={$row['birthday']} /> </td>
    <td> <input name='zipcode_arr[$count]' type='text' value={$row['zipcode']} /> </td>
    <td> <input name='id_arr[$count]' type='text' value={$row['id']} /> </td>
    <td> <input name='address_arr[$count]' type='text' value={$row['address']} /> </td>
LABEL;
}

function td_input_info2_empty($count) {
    echo <<<LABEL
    <td> <input name='birthday_arr[$count]' type='text' /> </td>
    <td> <input name='zipcode_arr[$count]' type='text' /> </td>
    <td> <input name='id_arr[$count]' type='text' /> </td>
    <td> <input name='address_arr[$count]' type='text' /> </td>
LABEL;
}

?>
