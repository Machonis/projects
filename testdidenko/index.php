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
        //}
// КОНЕЦ Создания массива из номеров, которые ввел пользователь
        $size =3; // Размер Таблицы = $size*$size.
                 //МОЖНО выбирать любой размер матрицы.
                
        static $k=1;
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
                   for ($i = 1; $i <= $rowCount - 1; $i++) {
                           if (min($arrRowsCell[$i]) != min($arrRowsCell[$i+1]) - $size && max($arrRowsCell[$i]) != max($arrRowsCell[$i+1]) - $size) {
                               echo 'Bad!';
                           }
                           if ($i == $rowCount - 1) {
                               for ($j = 1; $j <= $rowCount - 1; $j++) {
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

    for($i=0;$i<count($arr_cells); $i++) {
        //запоминая для каждой группы ячеек нужные данные
        $color[$arr_cells[$i]-1]   = $arr['color'];
        $bgcolor[$arr_cells[$i]-1] = $arr['bgcolor'];
        $text[$arr_cells[$i]-1]    = $arr['text'];
        $align[$arr_cells[$i]-1]   = $arr['align'];
        $valign[$arr_cells[$i]-1]  = $arr['valign'];

        $count = count($arr_cells);
        $row = 1;

        for($s= $count-2 ,$j=1;$j<$count,$s >= 0; $j++, $s--)
        {
            $class[$arr_cells[$i][$j]-1] = 'hidden';// для ненужных мне ячеек присваиваю класс
            //Устанавливаю число ячеек, которые должны быть объединены по вертикали.
            if(($arr_cells[$i][$count -$j] - $arr_cells[$i][$s]) != 1 )
            {
                $row++;
            } 
        }
        $col =$count/$row;//Устанавливаю число ячеек, которые должны быть объединены по горизонтали
        $colspan[$arr_cells[$i][0]-1] = $col;
        $rowspan[$arr_cells[$i][0]-1] = $row;
        // Проверка того если номера ячеек идут подряд
        for($l=1;$l<$count;$l++)
	{
            if((max($arr_cells[$i])-min($arr_cells[$i])) == $l*$size-1)
            {
		$rowspan[$arr_cells[$i][0]-1] = $count/$size;
		$colspan[$arr_cells[$i][0]-1] = $size; 
            }
	}
        // КОНЕЦ Проверки того если номера ячеек идут подряд
    }
//КОНЕЦ Основного кода программы
 ?>  
    
    
    
<div class=" container-fluid">
    <div class=" row">
        <div class=" col-lg-<?php echo$size?>">
            <table class="table table-bordered">
                <?php for($i=0;$i<$size;$i++)
                        {?>
                <tr>
                    <?php  for($j=0;$j<$size;$j++,$k++){ ?>
                    <td colspan="<?php echo $colspan[$k-1]?>" 
                        rowspan="<?php echo $rowspan[$k-1]?>"  
                        class="<?php echo $class[$k-1]?>"  
                        style="
                                width: <?php echo $colspan[$k-1]*$width[$k-1].'px';?>; 
                                height: <?php echo $rowspan[$k-1]*$height[$k-1].'px';?>; 
                                background: <?php echo $bgcolor[$k-1]?>; 
                                color: <?php echo $color[$k-1]?>; 
                                text-align: <?php echo $align[$k-1]?>; 
                                vertical-align: <?php echo $valign[$k-1]?>; 
                                ">
                    <?php echo $text[$k-1];?></td>
                                                <?php }?>
                </tr>
                <?php  }?>
            </table>
        </div>
    </div>
</div>
    
<?php }?><!--КОНЕЦ тела функции getTable-->
    
    <?php getTable($arr); ?><!-- Вызов функции getTable($arr)-->    
</body>
</html>
