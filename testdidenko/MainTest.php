<!DOCTYPE html>
<html lang="ru">
<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test task</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="js/bootstrap.js" rel="stylesheet">
</head>
<body>
    <?php
$arr =  [
        'text'    => "Test1",
        'cells'   => '2,5,8',
        'align'   => 'right',
        'valign'  => 'top',
        'color'   => 'red',
        'bgcolor' => 'blue'
        ];

    $size =3;
    $iterator=1;
?>

   <div class=" container-fluid">
    <div class=" row">
        <div class=" col-lg-<?php echo$size?>">
            <table class="table table-bordered">
                <?php for($i=0;$i<$size;$i++)
                        {?>
    <tr>
        <?php  for($j=0;$j<$size;$j++,$iterator++){ ?>
            <td
                style="
                        width: 100px;
                        height: 100px;
                        text-align: center;
                        vertical-align: middle;
                        ">
                <?php echo $iterator;?></td>
        <?php }?>
    </tr>
    <?php  }?>
    </table>
    </div>
    </div>
    </div>

    <?php function getTable(array $arr){
    // Создаю массив из номеров ячеек  которые ввел пользователь в массивв $arr под 
    // ключем cells и тутже его сортирую в порядке возрастания 
        /*for($i = 0;$i < count($arr);$i++)
        {*/
            $delimiter =',';
            $arr_cells = explode($delimiter, $arr ['cells']);
            $count = count($arr_cells);
            $rowCount = 0;
        //}
// КОНЕЦ Создания массива из номеров, которые ввел пользователь
        $size =3; // Размер Таблицы = $size*$size.
                 //МОЖНО выбирать любой размер матрицы.

//Под каждый элемент создаю отдельный массив
        $colspan = [];
        $rowspan = [];
        $width   = [];
        $height  = [];
        $class   = [];
        $color   = [];
        $bgcolor = [];
        $text    = [];
//Заполняю тадлицу данными по умолчанию
    for($i=1; $i <= $size*$size; $i++)
    {
        $width[] = '100';
        $height[] = '100';
        $colspan[] = '1';
        $rowspan[] = '1';
        $text[] = $i;
    }
//Основной код программы
    $arrAll =[];

    for ($i = 1; $i <= $size*$size; $i++) {
        $arrAll[$i] = "$i";
    }

    sort($arr_cells);

    for ($i = 1; $i <= $size; $i++) {
        if ($i -1 <= intdiv(max($arr_cells) - min($arr_cells), $size) && intdiv($a = max($arr_cells) - $b = min($arr_cells), $size) <= $i ) {
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
                   for ($i = 1; $i < $rowCount ; $i++) {
                           if (min($arrRowsCell[$i]) != min($arrRowsCell[$i+1]) - $size && max($arrRowsCell[$i]) != max($arrRowsCell[$i+1]) - $size) {
                               echo 'Bad!';
                           }
                           if ($i == $rowCount - 1) {
                               for ($j = 1; $j < $rowCount ; $j++) {
                                   if (count($arrRowsCell[$j]) != count($arrRowsCell[$j + 1])) {
                                       echo 'Bad!';
                                   }
                               }
                           }
                   }
       } else {
           for ($j = min($arr_cells); $j <= max($arr_cells); $j++) {
               if (in_array($arrAll[$j], $arr_cells) == false) {
                   echo 'Bad!';
               }
           }
       }

       echo 'ALL right';

    for($i=0;$i < count($arr_cells); $i++) {
        //запоминая для каждой группы ячеек нужные данные
        $color[$arr_cells[$i]]   = $arr['color'];
        $bgcolor[$arr_cells[$i]] = $arr['bgcolor'];
        $text[$arr_cells[$i]]    = $arr['text'];
        $align[$arr_cells[$i]]   = $arr['align'];
        $valign[$arr_cells[$i]]  = $arr['valign'];
        $colspan[$arr_cells[$i]] = 1;
        $rowspan[$arr_cells[$i]] = 1;

        if ($i == max($arr_cells)) {
            $colspan[$arr_cells[$i]] = $count / $rowCount;;
            $rowspan[$arr_cells[$i]] = $rowCount;
        }

    }
//КОНЕЦ Основного кода программы
 ?>  
    
    
    
<div class=" container-fluid">
    <div class=" row">
        <div class=" col-lg-<?php echo$size?>">
            <table class="table table-bordered">
                <?php
                $iterator = 1;
                for($i=0;$i < $size;$i++)
                        { ?>
                <tr>
                    <?php for($j= 0;$j < $size;$j++, $iterator++){
                        /*if (!in_array($arr_cells[$i+2], $arrAll)):*/?>
                    <td colspan="<?php echo $colspan[$iterator - 1]?>"
                        rowspan="<?php echo $rowspan[$iterator - 1]?>"
                        style="
                                width: <?php echo $colspan[$iterator - 1]*$width[$iterator - 1].'px';?>;
                                height: <?php echo $rowspan[$iterator - 1]*$height[$iterator - 1].'px';?>;
                                background: <?php echo $bgcolor[$iterator - 1]?>;
                                color: <?php echo $color[$iterator - 1]?>;
                                text-align: <?php echo $align[$iterator - 1]?>;
                                vertical-align: <?php echo $valign[$iterator - 1]?>;
                                ">
                    <?php echo $text[$iterator - 1];?></td>
                                                <?php /*endif;*/ }?>
                </tr>
                <?php }?>
            </table>
        </div>
    </div>
</div>
    
<?php }?><!--КОНЕЦ тела функции getTable-->
    
    <?php getTable($arr); ?><!-- Вызов функции getTable($arr)-->    
</body>
</html>
