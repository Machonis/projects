<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ДЗ №4 'Funbctions'</title>
    <style type="text/css">
        html {height: 80%;}
        body {margin: 2%;padding: 0;height: 100%;}
        div#conteiner {
            width: 100%;
            height: 100%;
            font-style: italic;
        }
        div#mincon {
            float: left;
            width: 100%;
        }
        div#green1 {
            height: 100%;
            background:#0A1BBE;
            float: left;
            border: 2px outset #9FC1F0;
            box-sizing:border-box;
            font-style: oblique;
        }
        div#green2 {
            height: 100%;
            background:#0A1BBE;
            float: left;
            border: 2px outset #9FC1F0;
            box-sizing:border-box;
            font-style: oblique;
        }
        div#main {
            height: 100%;
            background:#10AFB5;
            float: left;
            border: 2px outset #9FC1F0;;
            box-sizing:border-box;
            font-style: oblique;
        }
    </style>
</head>
<body>
<div id='conteiner'>
    <div id='mincon' style="font-style: italic; color: #F47611; font-size: 1.5em "><strong><center>Крутая табличка:)</center></strong></div>
<?php
error_reporting(E_ALL);
$col=7;
$row=15;
$result='';
function table($col,$row) {
	$width=100/$col;
	$height=100/$row;
	$result='';
	for ($j=1; $j<=$row; $j++) {
		$result.="<div id='mincon' style=' height:" .$height."%;'>";
		$result.="<div id='green1' style=' width:" .$width."%;'><strong><center>$j</center></strong></div>";
	for ($i=1; $i <= $col; $i++) {
		if ($j==1 && $i>=2)
		$result.="<div id='green2' style=' width:" .$width."%;'><strong><center>$i</center></strong></div>";
		if ($j>1 && $i>=2)
		$result.="<div id='main' style=' width:" .$width."%;'><strong><center>".$j*$i."</center></strong></div>";
		}
		$result.="</div>";
	}
	return $result;
}
$result=table($col,$row);
echo $result;
?>
</div>
</body>
</html>