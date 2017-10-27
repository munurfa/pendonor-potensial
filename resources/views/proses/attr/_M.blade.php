<?php
$MenPro = collect(['-INF-525' => range(0, 524),
                 '525-1925' => range(525, 1924),
                 '1925-INF' => range(1925, 50000),
                 ]);
?>
@foreach($MenPro as $key => $val)
<?php
$v = $proses->whereInLoose('m', $val)->count();
${$key.'en1'} = $proses->whereInLoose('m', $val)->whereLoose('c', 0)->count();
${$key.'en2'} = $proses->whereInLoose('m', $val)->whereLoose('c', 1)->count();
${$key.'Men1'} = (-${$key.'en1'} / $v) * log(${$key.'en1'} / $v, 2);
${$key.'Men2'} = (-${$key.'en2'} / $v) * log(${$key.'en2'} / $v, 2);
$enM = ${$key.'Men1'} + ${$key.'Men2'};
$enM = (is_nan($enM)) ? 0 : $enM;
$totMPro[$key] = [
'enM' => $enM,
'jmkasM' => $v,
];
?>
@endforeach

<tr>
    <td></td>
    <td>M</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        <?php
        $MPro = collect(['-INF-525' => range(0, 524),
                 '525-1925' => range(525, 1924),
                 '1925-INF' => range(1925, 50000),
                 ]);

        $gPro = 0;
        foreach ($MPro as $key => $val) {
            ${'en'.$key} = (float) $totMPro[$key]['enM'];
            ${'val'.$key} = (float) $totMPro[$key]['jmkasM'];

            $gPro -= ((${'val'.$key} / $allPro) * ${'en'.$key});
        }

        $gainPro = $entotPro - (-($gPro));
        echo number_format($gainPro, 10);
        ?>
    </td>
</tr>
<?php
// die();
$MPro = collect(['-INF-525' => range(0, 524),
                 '525-1925' => range(525, 1924),
                 '1925-INF' => range(1925, 50000),
                 ]);

?>
@foreach($MPro as $key => $val)
<tr>
    <td></td>
    <td></td>
    <td>{{$key}}</td>
    <td>{{ $v = $proses->whereInLoose('m',$val)->count()}}</td>
    <td>{{ ${$key.'1'} = $proses->whereInLoose('m',$val)->whereLoose('c',0)->count() }}</td>
    <td>{{ ${$key.'2'} = $proses->whereInLoose('m',$val)->whereLoose('c',1)->count() }}</td>
    <?php
    ${$key.'m1'} = (-${$key.'1'} / $v) * log(${$key.'1'} / $v, 2);
    ${$key.'m2'} = (-${$key.'2'} / $v) * log(${$key.'2'} / $v, 2);
    $entropi = ${$key.'m1'} + ${$key.'m2'};
    $entropi = (is_nan($entropi)) ? 0 : $entropi;
    ?>
    <td><?php echo $entropi; ?></td>
    <td></td>
</tr>
@endforeach
