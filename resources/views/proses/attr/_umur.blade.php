<?php
$umurenPro = collect(['-INF-32.5' => range(1, 32),
'32.5-INF' => range(33, 70),
]);
?>
@foreach($umurenPro as $key => $val)
<?php
$v = $proses->whereInLoose('umur', $val)->count();
${$key.'en1'} = $proses->whereInLoose('umur', $val)->whereLoose('c', 0)->count();
${$key.'en2'} = $proses->whereInLoose('umur', $val)->whereLoose('c', 1)->count();
${$key.'umuren1'} = (-${$key.'en1'} / $v) * log(${$key.'en1'} / $v, 2);
${$key.'umuren2'} = (-${$key.'en2'} / $v) * log(${$key.'en2'} / $v, 2);
$enumur = ${$key.'umuren1'} + ${$key.'umuren2'};
$enumur = (is_nan($enumur)) ? 0 : $enumur;
$totumurPro[$key] = [
'enumur' => $enumur,
'jmkasumur' => $v,
];
// echo ${$key.'jken1'}+${$key.'jken2'}.'<br>';
?>
@endforeach


<tr>
    <td></td>
    <td>UMUR</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        <?php
        $umurPro = collect(['-INF-32.5' => range(1, 32),
        '32.5-INF' => range(33, 70),
        ]);

        $gPro = 0;
        foreach ($umurPro as $key => $val) {
            ${'en'.$key} = (float) $totumurPro[$key]['enumur'];
            ${'val'.$key} = (float) $totumurPro[$key]['jmkasumur'];

            $gPro -= ((${'val'.$key} / $allPro) * ${'en'.$key});
        }

        $gainPro = $entotPro - (-($gPro));
        echo number_format($gainPro, 10);
        ?>
    </td>
</tr>
<?php
// die();
$umurPro = collect(['-INF-32.5' => range(1, 32),
'32.5-INF' => range(33, 70),
]);
?>
@foreach($umurPro as $key => $val)
<tr>
    <td></td>
    <td></td>
    <td>{{$key}}</td>
    <td>{{ $v = $proses->whereInLoose('umur',$val)->count()}}</td>
    <td>{{ ${$key.'1'} = $proses->whereInLoose('umur',$val)->whereLoose('c',0)->count() }}</td>
    <td>{{ ${$key.'2'} = $proses->whereInLoose('umur',$val)->whereLoose('c',1)->count() }}</td>
    <?php
    ${$key.'umur1'} = (-${$key.'1'} / $v) * log(${$key.'1'} / $v, 2);
    ${$key.'umur2'} = (-${$key.'2'} / $v) * log(${$key.'2'} / $v, 2);
    $entropi = ${$key.'umur1'} + ${$key.'umur2'};
    $entropi = (is_nan($entropi)) ? 0 : $entropi;
    ?>
    <td><?php echo $entropi; ?></td>
    <td></td>
</tr>
@endforeach
