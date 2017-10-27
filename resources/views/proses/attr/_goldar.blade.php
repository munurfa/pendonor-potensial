<?php
$golenPro = $proses->groupBy('goldar');
$golenPro = $golenPro->map(function ($item, $key) {
    return collect($item)->count();
});

?>

@foreach($golenPro as $key => $val)
<?php
${$key.'en1'} = $proses->where('goldar', $key)->whereLoose('c', 0)->count();
${$key.'en2'} = $proses->where('goldar', $key)->whereLoose('c', 1)->count();

${$key.'golen1'} = (-${$key.'en1'} / $val) * log(${$key.'en1'} / $val, 2);
${$key.'golen2'} = (-${$key.'en2'} / $val) * log(${$key.'en2'} / $val, 2);
$engol = ${$key.'golen1'} + ${$key.'golen2'};
$engol = (is_nan($engol)) ? 0 : $engol;
$totgolPro[$key] = [
'engol' => $engol,
'jmkasgol' => $val,
];
// echo ${$key.'jken1'}+${$key.'jken2'}.'<br>';
?>
@endforeach
<tr>
    <td></td>
    <td>GOLDAR</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        <?php
        $golPro = $proses->groupBy('goldar');

        $gPro = 0;
        foreach ($golPro as $key => $val) {
            ${'en'.$key} = (float) $totgolPro[$key]['engol'];
            ${'val'.$key} = (float) $totgolPro[$key]['jmkasgol'];

            $gPro -= ((${'val'.$key} / $allPro) * ${'en'.$key});
        }

        $gainPro = $entotPro - (-($gPro));
        echo number_format($gainPro, 10);
    ?></td>
</tr>
<?php
// die();
$golPro = $proses->groupBy('goldar');
// $jk = $jk->values()->all();
$golPro = $golPro->map(function ($item, $key) {
    return collect($item)->count();
});
            // echo "<pre>";
                        // print_r ($jk);
// echo "</pre>";
// foreach ($jk as $key => $value) {
//     echo $key.'=='.$value.'<br>';
// }
?>
@foreach($golPro as $key => $val)
<tr>
    <td></td>
    <td></td>
    <td>{{$key}}</td>
    <td>{{$val}}</td>
    <td>{{ ${$key.'1'} = $proses->where('goldar',$key)->whereLoose('c',0)->count() }}</td>
    <td>{{ ${$key.'2'} = $proses->where('goldar',$key)->whereLoose('c',1)->count() }}</td>
    <?php
    ${$key.'gol1'} = (-${$key.'1'} / $val) * log(${$key.'1'} / $val, 2);
    ${$key.'gol2'} = (-${$key.'2'} / $val) * log(${$key.'2'} / $val, 2);
    $entropi = ${$key.'gol1'} + ${$key.'gol2'};
    $entropi = (is_nan($entropi)) ? 0 : $entropi;
    ?>
    <td><?php echo $entropi; ?></td>
    <td></td>
</tr>
@endforeach
