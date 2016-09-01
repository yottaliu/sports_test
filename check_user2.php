<th><label>用户名</label></th>
<th><label>密码</label></th>
<th><label>用户类型</label></th>
<th><label>班级编号</label></th>

<?php
function td_input_user2_empty($count) {
    echo <<<LABEL
    <td><input name='username_arr[$count]' type='text' /></td>
    <td><input name='password_arr[$count]' type='password' /></td>
    <td>
        <select name='type_arr[$count]'>
            <option value='管理员' selected='selected'>管理员</option>
            <option value='素质导师'>素质导师</option>
            <option value='录入人员'>录入人员</option>
            <option value='学生'>学生</option>
        </select>
    </td>
    <td><input name='classid_arr[$count]' type='text' /></td>
LABEL;
}

?>
