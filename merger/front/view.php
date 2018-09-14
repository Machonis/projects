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
    'text' => 'Test1',
    'cells' => '8,9',
    'align' => 'center',
    'valign' => 'middle',
    'color' => 'white',
    'bgcolor' => 'blue'
];

$col = 5;
$row = 5;

$table = new Table($arr,$col,$row);
echo $table->getUnmodifiedTable();
echo $table->getModifiedTable();
?>

</body>
</html>
