<th>身高</th>
<th>体重</th>
<th>肺活量</th>
<th>50米跑</th>
<th>立定跳远</th>
<th>坐位体前屈</th>
<th>800/1000米跑</th>
<th>引体向上/仰卧起坐</th>
<th>左眼视力</th>
<th>右眼视力</th>

<?php
function td_show_score($row) {
    echo <<<LABEL
    <td> {$row['height']} </td>
    <td> {$row['weight']} </td>
    <td> {$row['fvc']} </td>
    <td> {$row['shortrunning']} </td>
    <td> {$row['jump']} </td>
    <td> {$row['sitandreach']} </td>
    <td> {$row['longrunning']} </td>
    <td> {$row['pulluporsitup']} </td>
    <td> {$row['lefteye']} </td>
    <td> {$row['righteye']} </td>
LABEL;
}

function td_input_score($row, $count) {
    echo <<<LABEL
    <td> <input name='height_arr[$count]' type='text' value={$row['height']} /> </td>
    <td> <input name='weight_arr[$count]' type='text' value={$row['weight']} /> </td>
    <td> <input name='fvc_arr[$count]' type='text' value={$row['fvc']} /> </td>
    <td> <input name='shortrunning_arr[$count]' type='text' value={$row['shortrunning']} /> </td>
    <td> <input name='jump_arr[$count]' type='text' value={$row['jump']} /> </td>
    <td> <input name='sitandreach_arr[$count]' type='text' value={$row['sitandreach']} /> </td>
    <td> <input name='longrunning_arr[$count]' type='text' value={$row['longrunning']} /> </td>
    <td> <input name='pulluporsitup_arr[$count]' type='text' value={$row['pulluporsitup']} /> </td>
    <td> <input name='lefteye_arr[$count]' type='text' value={$row['lefteye']} /> </td>
    <td> <input name='righteye_arr[$count]' type='text' value={$row['righteye']} /> </td>
LABEL;
}

function td_show_score_empty() {
    echo <<<LABEL
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
LABEL;
}

function td_input_score_empty($count) {
    echo <<<LABEL
    <td> <input name='height_arr[$count]' type='text' /> </td>
    <td> <input name='weight_arr[$count]' type='text' /> </td>
    <td> <input name='fvc_arr[$count]' type='text' /> </td>
    <td> <input name='shortrunning_arr[$count]' type='text' /> </td>
    <td> <input name='jump_arr[$count]' type='text' /> </td>
    <td> <input name='sitandreach_arr[$count]' type='text' /> </td>
    <td> <input name='longrunning_arr[$count]' type='text' /> </td>
    <td> <input name='pulluporsitup_arr[$count]' type='text' /> </td>
    <td> <input name='lefteye_arr[$count]' type='text' /> </td>
    <td> <input name='righteye_arr[$count]' type='text' /> </td>
LABEL;
}

?>
