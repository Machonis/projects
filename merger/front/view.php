<?php declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use projects\merger\back\Table;

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='style.css' rel='stylesheet' type='text/css'>
    <title>Test task</title>
</head>
<body>

<?php
$arr = [
    [
        'text' => 'Test1',
        'cells' => '2,3,5,6',
        'align' => 'center',
        'valign' => 'middle',
        'color' => 'white',
        'bgcolor' => 'blue'
    ],

    [
        'text' => 'Test2',
        'cells' => '1,4',
        'align' => 'center',
        'valign' => 'middle',
        'color' => 'white',
        'bgcolor' => 'blue'
    ],

    [
        'text' => 'Test2',
        'cells' => '8,9',
        'align' => 'center',
        'valign' => 'middle',
        'color' => 'white',
        'bgcolor' => 'blue'
    ],
];

$col = 3;
$row = 3;

$table = new Table($arr,$col,$row);?>
<div class="container">
    <div>
        <h1>Unmodified table</h1>
    </div>
    <?php echo $table->getUnmodifiedTable();?>
</div>
<div class="container">
    <div>
        <h1>Modified table</h1>
    </div>
    <?php echo $table->getModifiedTable();?>
</div>
</body>
</html>
