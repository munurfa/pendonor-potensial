<?php

$jkenPro = $proses->groupBy('jk');
$jkenPro = $jkenPro->map(function ($item, $key) {
    return collect($item)->count();
});
?>

@foreach($jkenPro as $key => $val)
<?php
${$key.'en1'} = $proses->where('jk', $key)->whereLoose('c', 0)->count();
${$key.'en2'} = $proses->where('jk', $key)->whereLoose('c', 1)->count();

${$key.'jken1'} = (-${$key.'en1'} / $val) * log(${$key.'en1'} / $val, 2);
${$key.'jken2'} = (-${$key.'en2'} / $val) * log(${$key.'en2'} / $val, 2);
$enjk = ${$key.'jken1'} + ${$key.'jken2'};
$enjk = (is_nan($enjk)) ? 0 : $enjk;
$totjkPro[$key] = [
'enjk' => $enjk,
'jmkasjk' => $val,
];
// echo ${$key.'jken1'}+${$key.'jken2'}.'<br>';
?>

@endforeach
<tr>
    <td></td>
    <td>JENIS KELAMIN</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        <?php
        $jkPro = $proses->groupBy('jk');

        $gPro = 0;
        foreach ($jkPro as $key => $val) {
            ${'en'.$key} = (float) $totjkPro[$key]['enjk'];
            ${'val'.$key} = (float) $totjkPro[$key]['jmkasjk'];

            $gPro -= ((${'val'.$key} / $allPro) * ${'en'.$key});
        }

        $gainPro = $entotPro - (-($gPro));

        echo number_format($gainPro, 10);
    ?></td>
</tr>
<?php
$jkPro = $proses->groupBy('jk');
// $jk = $jk->values()->all();
$jkPro = $jkPro->map(function ($item, $key) {
    return collect($item)->count();
});
            // echo "<pre>";
                // print_r ($jk);
// echo "</pre>";
// foreach ($jk as $key => $value) {
//     echo $key.'=='.$value.'<br>';
// }
?>
@foreach($jkPro as $key => $val)
<tr>
    <td></td>
    <td></td>
    <td>{{$key}}</td>
    <td>{{$val}}</td>
    <td>{{ ${$key.'1'} = $proses->where('jk',$key)->whereLoose('c',0)->count() }}</td>
    <td>{{ ${$key.'2'} = $proses->where('jk',$key)->whereLoose('c',1)->count() }}</td>
    <?php
    ${$key.'jk1'} = (-${$key.'1'} / $val) * log(${$key.'1'} / $val, 2);
    ${$key.'jk2'} = (-${$key.'2'} / $val) * log(${$key.'2'} / $val, 2);
    $entropi = ${$key.'jk1'} + ${$key.'jk2'};
    $entropi = (is_nan($entropi)) ? 0 : $entropi;
    ?>
    <td><?php echo $entropi; ?></td>
    <td></td>
</tr>
@endforeach
