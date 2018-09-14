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
    'cells' => '14,15,19,20,24,25',
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
    $arr_cells = [];

    $delimiter = ',';
    $arr_cell = explode($delimiter, $arr ['cells']);
    sort($arr_cell);

    foreach ($arr_cell as $key => $value) {
        $arr_cells[$key+1] = $arr_cell[$key];
    }
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
        $width[$i] = '100';
        $height[$i] = '100';
        $colspan[$i] = '1';
        $rowspan[$i] = '1';
        $text[$i] = $i;
    }

    $arrAll = [];

    for ($i = 1; $i <= $size * $size; $i++) {
        $arrAll[$i] = $i;
    }

    for ($i = 1; $i <= $size; $i++) {
        if ($i - 1 <= intdiv(max($arr_cells) - min($arr_cells),
                $size) && intdiv($a = max($arr_cells) - $b = min($arr_cells), $size) <= $i) {
            $rowCount = $i;
        }
    }

    $arrRowsCells = [];
    $iterator = 1;

    for ($i = 1; $i <= $size; $i++) {
        for ($j = 1; $j <= $size; $j++) {
            if (in_array($arrAll[$iterator], $arr_cells)) {
                $arrRowsCells[$i][] = $arrAll[$iterator];
            }
            $iterator++;
        }
    }

    $iterator = 1;
    $iterator2 = 1;

    $arrRowsCell = [];

    foreach ($arrRowsCells as $key1 => $value1) {
        foreach ($value1 as $key2 => $value2) {
            $arrRowsCell[$iterator][$iterator2] = $arrRowsCells[$key1][$key2];
            $iterator2++;
        }
        $iterator2 = 1;
        $iterator++;
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

    foreach ($arrAll as $value) {
        if (in_array($value, $arr_cells)) {
            $color[$value] = $arr['color'];
            $bgcolor[$value] = $arr['bgcolor'];
            $text[$value] = $arr['text'];
            $align[$value] = $arr['align'];
            $valign[$value] = $arr['valign'];
            $colspan[$value] = 1;
            $rowspan[$value] = 1;

            if ($value == min($arr_cells)) {
                $colspan[$value] = $count / $rowCount;
                $rowspan[$value] = $rowCount;
            }
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
                                        $arr_cells) == false xor $arrAll[$iterator] == $arr_cells[1]):?>
                                    <td colspan="<?php echo $colspan[$iterator] ?>"
                                        rowspan="<?php echo $rowspan[$iterator] ?>"
                                        style="
                                                width: <?php echo $colspan[$iterator] * $width[$iterator] . 'px'; ?>;
                                                height: <?php echo $rowspan[$iterator] * $height[$iterator] . 'px'; ?>;
                                                background: <?php echo $bgcolor[$iterator] ?>;
                                                color: <?php echo $color[$iterator] ?>;
                                                text-align: <?php echo $align[$iterator] ?>;
                                                vertical-align: <?php echo $valign[$iterator] ?>;
                                                ">
                                        <?php echo $text[$iterator]; ?></td>
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
