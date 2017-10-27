<?php
// $golenPro = $proses->groupBy('goldar');
$RenPro = collect(['-INF-0.5' => range(0, 0),
        '0.5-1.5' => range(1, 1),
        '1.5-5.5' => range(2, 5),
        '5.5-INF' => range(6, 100),
]);
?>
@foreach($RenPro as $key => $val)
<?php
$v = $proses->whereInLoose('r', $val)->count();
${$key.'en1'} = $proses->whereInLoose('r', $val)->whereLoose('c', 0)->count();
${$key.'en2'} = $proses->whereInLoose('r', $val)->whereLoose('c', 1)->count();
${$key.'Ren1'} = (-${$key.'en1'} / $v) * log(${$key.'en1'} / $v, 2);
${$key.'Ren2'} = (-${$key.'en2'} / $v) * log(${$key.'en2'} / $v, 2);
$enR = ${$key.'Ren1'} + ${$key.'Ren2'};
$enR = (is_nan($enR)) ? 0 : $enR;
$totRPro[$key] = [
'enR' => $enR,
'jmkasR' => $v,
];
// echo ${$key.'jken1'}+${$key.'jken2'}.'<br>';
?>
@endforeach
<tr>
    <td></td>
    <td>R</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        <?php
        $RPro = collect(['-INF-0.5' => range(0, 0),
        '0.5-1.5' => range(1, 1),
        '1.5-5.5' => range(2, 5),
        '5.5-INF' => range(6, 100),
        ]);

        $gPro = 0;
        foreach ($RPro as $key => $val) {
            ${'en'.$key} = (float) $totRPro[$key]['enR'];
            ${'val'.$key} = (float) $totRPro[$key]['jmkasR'];

            $gPro -= ((${'val'.$key} / $allPro) * ${'en'.$key});
        }

        $gainPro = $entotPro - (-($gPro));
        echo number_format($gainPro, 10);
        ?>
    </td>
</tr>
<?php
// die();
$RPro = collect(['-INF-0.5' => range(0, 0),
'0.5-1.5' => range(1, 1),
'1.5-5.5' => range(2, 5),
'5.5-INF' => range(6, 100),
]);

?>
@foreach($RPro as $key => $val)
<tr>
    <td></td>
    <td></td>
    <td>{{$key}}</td>
    <td>{{ $v = $proses->whereInLoose('r',$val)->count()}}</td>
    <td>{{ ${$key.'1'} = $proses->whereInLoose('r',$val)->whereLoose('c',0)->count() }}</td>
    <td>{{ ${$key.'2'} = $proses->whereInLoose('r',$val)->whereLoose('c',1)->count() }}</td>
    <?php
    ${$key.'r1'} = (-${$key.'1'} / $v) * log(${$key.'1'} / $v, 2);
    ${$key.'r2'} = (-${$key.'2'} / $v) * log(${$key.'2'} / $v, 2);
    $entropi = ${$key.'r1'} + ${$key.'r2'};
    $entropi = (is_nan($entropi)) ? 0 : $entropi;
    ?>
    <td><?php echo $entropi; ?></td>
    <td></td>
</tr>
@endforeach
