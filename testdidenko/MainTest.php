<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test task</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" media="screen"/>
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<?php
$arr = [
    'text' => "Test1",
    'cells' => '1,2,3,4,5',
    'align' => 'center',
    'valign' => 'middle',
    'color' => 'white',
    'bgcolor' => 'blue'
];

$size = 5;
$iterator = 1;
?>

<div class=" container-fluid">
    <div class=" row">
        <div class=" col-lg-<?php echo $size ?>">
            <table class="table table-bordered">
                <?php for ($i = 0; $i < $size; $i++) {
                    ?>
                    <tr>
                        <?php for ($j = 0; $j < $size; $j++, $iterator++) { ?>
                            <td
                                    style="
                        width: 100px;
                        height: 100px;
                        text-align: center;
                        vertical-align: middle;
                        ">
                                <?php echo $iterator; ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<?php
/**
 * @param array $arr
 * @throws Exception
 */
function getTable(array $arr)
{

    $size = 5;

    $delimiter = ',';
    $arr_cells = explode($delimiter, $arr ['cells']);
    $count = count($arr_cells);
    $rowCount = 0;

    $colspan = [];
    $rowspan = [];
    $width = [];
    $height = [];
    $color = [];
    $bgcolor = [];
    $text = [];

    for ($i = 1; $i <= $size * $size; $i++) {
        $width[] = '100';
        $height[] = '100';
        $colspan[] = '1';
        $rowspan[] = '1';
        $text[] = $i;
    }

    $arrAll = [];

    for ($i = 1; $i <= $size * $size; $i++) {
        $arrAll[$i] = "$i";
    }

    sort($arr_cells);

    for ($i = 1; $i <= $size; $i++) {
        if ($i - 1 <= intdiv(max($arr_cells) - min($arr_cells),
                $size) && intdiv($a = max($arr_cells) - $b = min($arr_cells), $size) <= $i) {
            $rowCount = $i;
        }
    }

    $arrRowsCell = [];
    $iterator = 1;

    for ($i = 1; $i <= $size; $i++) {
        for ($j = 1; $j <= $size; $j++) {
            if (in_array($arrAll[$iterator], $arr_cells)) {
                $arrRowsCell[$i][] = $arrAll[$iterator];
            }
            $iterator++;
        }
    }

    if ($rowCount != 1) {
        for ($i = 1; $i < $rowCount; $i++) {
            if (min($arrRowsCell[$i]) != min($arrRowsCell[$i + 1]) - $size && max($arrRowsCell[$i]) != max($arrRowsCell[$i + 1]) - $size) {
                throw new Exception('These can\'t be combined!');
            }
            if ($i == $rowCount - 1) {
                for ($j = 1; $j < $rowCount; $j++) {
                    if (count($arrRowsCell[$j]) != count($arrRowsCell[$j + 1])) {
                        throw new Exception('These can\'t be combined!');
                    }
                }
            }
        }
    } else {
        for ($j = min($arr_cells); $j <= max($arr_cells); $j++) {
            if (in_array($arrAll[$j], $arr_cells) == false) {
                throw new Exception('These can\'t be combined!');
            }
        }
    }

    for ($i = 0; $i < count($arr_cells); $i++) {
        $color[$arr_cells[$i] - 1] = $arr['color'];
        $bgcolor[$arr_cells[$i] - 1] = $arr['bgcolor'];
        $text[$arr_cells[$i] - 1] = $arr['text'];
        $align[$arr_cells[$i] - 1] = $arr['align'];
        $valign[$arr_cells[$i] - 1] = $arr['valign'];
        $colspan[$arr_cells[$i] - 1] = 1;
        $rowspan[$arr_cells[$i] - 1] = 1;

        if ($i == min($arr_cells)) {
            $colspan[$i - 1] = $count / $rowCount;
            $rowspan[$i - 1] = $rowCount;
        }

    }

    ?>


    <div class=" container-fluid">
        <div class=" row">
            <div class=" col-lg-<?php echo $size ?>">
                <table class="table table-bordered">
                    <?php
                    $iterator = 1;
                    for ($i = 0; $i < $size; $i++) { ?>
                        <tr>
                            <?php for ($j = 0; $j < $size; $j++, $iterator++) {
                                if (in_array($arrAll[$iterator],
                                        $arr_cells) == false xor $arrAll[$iterator] == $arr_cells[0]):?>
                                    <td colspan="<?php echo $colspan[$iterator - 1] ?>"
                                        rowspan="<?php echo $rowspan[$iterator - 1] ?>"
                                        style="
                                                width: <?php echo $colspan[$iterator - 1] * $width[$iterator - 1] . 'px'; ?>;
                                                height: <?php echo $rowspan[$iterator - 1] * $height[$iterator - 1] . 'px'; ?>;
                                                background: <?php echo $bgcolor[$iterator - 1] ?>;
                                                color: <?php echo $color[$iterator - 1] ?>;
                                                text-align: <?php echo $align[$iterator - 1] ?>;
                                                vertical-align: <?php echo $valign[$iterator - 1] ?>;
                                                ">
                                        <?php echo $text[$iterator - 1]; ?></td>
                                <?php endif;
                            } ?>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

<?php } ?>

<?php try {
    getTable($arr);
} catch (Exception $e) {
    echo $e->getMessage();
} ?>
</body>
</html>
