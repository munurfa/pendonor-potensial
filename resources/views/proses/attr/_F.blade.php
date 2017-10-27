<?php
$FenPro = collect(['-INF-1.5' => range(0, 1),
                 '1.5-5.5' => range(2, 5),
                 '5.5-INF' => range(6, 100),
                 ]);
?>
@foreach($FenPro as $key => $val)
<?php
$v = $proses->whereInLoose('f', $val)->count();
${$key.'en1'} = $proses->whereInLoose('f', $val)->whereLoose('c', 0)->count();
${$key.'en2'} = $proses->whereInLoose('f', $val)->whereLoose('c', 1)->count();
${$key.'Fen1'} = (-${$key.'en1'} / $v) * log(${$key.'en1'} / $v, 2);
${$key.'Fen2'} = (-${$key.'en2'} / $v) * log(${$key.'en2'} / $v, 2);
$enF = ${$key.'Fen1'} + ${$key.'Fen2'};
$enF = (is_nan($enF)) ? 0 : $enF;
$totFPro[$key] = [
'enF' => $enF,
'jmkasF' => $v,
];
?>
@endforeach
<tr>
    <td></td>
    <td>F</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        <?php
        $FPro = collect(['-INF-1.5' => range(0, 1),
                 '1.5-5.5' => range(2, 5),
                 '5.5-INF' => range(6, 100),
                 ]);

        $gPro = 0;
        foreach ($FPro as $key => $val) {
            ${'en'.$key} = (float) $totFPro[$key]['enF'];
            ${'val'.$key} = (float) $totFPro[$key]['jmkasF'];

            $gPro -= ((${'val'.$key} / $allPro) * ${'en'.$key});
        }

        $gainPro = $entotPro - (-($gPro));
        echo number_format($gainPro, 10);
        ?>

    </td>
</tr>
<?php
// die();
$FPro = collect(['-INF-1.5' => range(0, 1),
                 '1.5-5.5' => range(2, 5),
                 '5.5-INF' => range(6, 100),
                 ]);

?>
@foreach($FPro as $key => $val)
<tr>
    <td></td>
    <td></td>
    <td>{{$key}}</td>
    <td>{{ $v = $proses->whereInLoose('f',$val)->count()}}</td>
    <td>{{ ${$key.'1'} = $proses->whereInLoose('f',$val)->whereLoose('c',0)->count() }}</td>
    <td>{{ ${$key.'2'} = $proses->whereInLoose('f',$val)->whereLoose('c',1)->count() }}</td>
    <?php
    ${$key.'f1'} = (-${$key.'1'} / $v) * log(${$key.'1'} / $v, 2);
    ${$key.'f2'} = (-${$key.'2'} / $v) * log(${$key.'2'} / $v, 2);
    $entropi = ${$key.'f1'} + ${$key.'f2'};
    $entropi = (is_nan($entropi)) ? 0 : $entropi;
    ?>
    <td><?php echo $entropi; ?></td>
    <td></td>
</tr>
@endforeach
