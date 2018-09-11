<?php 
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
use projects\app\validatorGetAndPost;

echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<!--
 * 7. Сделайте класс-валидатор для $_GET и $_POST.
Класс должен иметь:
- private свойства post и get. Свойствам по-умолчанию присваиваются пустые массивы
- private метод для удаления пробелов (delGaps()) - оболочка над функцией trim
- private метод для удаления тегов (delTags()) - оболочка над strip_tags
- private метод handleRequest для обработки GET и POST массивов. Метод задействует
методы delGaps() и delTags() и заполняет свойства post и get. Метод принимает на вход
параметр request - массив с данными. Метод должен анализировать данные из request
параметра и распределить данные в get и post свойства. Для этого используйте
$_SERVER[‘REQUEST_METHOD’] для определения типа параметра - GET или POST.
Также проверьте массив COOKIE данные которого также могут быть переданы через
массив $_REQUEST.
- public метод для получения всех параметров getParams()
- public метод для получения параметра по ключу getParam($param)
Для проверки: при создании экземпляра класса в конструктор передается массив
$_REQUEST. В конструкторе класса значение передается в метод handleRequest(). Через экземпляр класса можно получить либо все массив параметров со значениями getParams() либо значение конкретного параметра getParam($_GET[‘id’]).
 *
 -->
<?php if (empty($_REQUEST)) :?>
    <div>
        <form action="index.php" method="POST" >
            <div>
                <div><strong>Данные GET</strong><input type="text" id="1" name='request' value=""></div>
                <div><strong>Данные GET</strong><input type="text" id="2" name='request2' value=""></div>
                <div><input type="submit" value="GO"></div>
            </div>
        </form>
    </div>

<?php endif ?>

<?php if (!empty($_REQUEST)) {
    $var='Tadas';
    echo "<pre>";
    var_dump($_REQUEST);
    echo "</pre>";
    setcookie('cookie', $var, time() + 60, '/');
    $object1 = new validatorGetAndPost($_REQUEST, $_COOKIE);

    var_dump($_COOKIE);

    echo "<pre>";
    var_dump($object1->getParams());
    echo "</pre>";


    echo "<pre>";
    var_dump($object1->getParam("request"));
    echo "</pre>";
}
?>
</body>
</html>