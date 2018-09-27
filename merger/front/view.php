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
$userArray = [
    [
        'text' => 'Test1',
        'cells' => '1,11',
        'align' => 'center',
        'valign' => 'middle',
        'color' => 'white',
        'bgcolor' => 'blue'
    ],

    [
        'text' => 'Test2',
        'cells' => '12,13',
        'align' => 'center',
        'valign' => 'middle',
        'color' => 'white',
        'bgcolor' => 'blue'
    ],

    [
        'text' => 'Test3',
        'cells' => '21,31',
        'align' => 'center',
        'valign' => 'middle',
        'color' => 'white',
        'bgcolor' => 'blue'
    ],

    [
        'text' => 'Test4',
        'cells' => '38,39,48,49',
        'align' => 'center',
        'valign' => 'middle',
        'color' => 'white',
        'bgcolor' => 'blue'
    ],
];

$colCount = 5;
$rowCount = 10;

$table = new Table($userArray,$colCount,$rowCount);?>
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
