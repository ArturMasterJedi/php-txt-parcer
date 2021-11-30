<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
if (!isset($_POST['send'])){
?>
<form method="post" action="addfilm.php">
    <label>Введите Title</label><br>
    <input name="name" type="text"><br>
    <label>Введите Release Year</label><br>
    <input name="release_year" type="text"><br>
    <label>Введите Format</label><br>
    <select name="format">
        <option value="vhs">VHS</option>
        <option value="dvd">DVD</option>
        <option value="blu-ray">Blu-Ray</option>
    </select><br>
    <label>Введите Stars</label><br>
    <input name="stars" type="text"><br>
    <input type="submit" name="send" value="SEND"><br>
</form>
<?php
}elseif (isset($_POST['send'], $_POST['name'], $_POST['release_year'], $_POST['format'], $_POST['stars']) && !empty($_POST['release_year']) && !empty($_POST['name']) && !empty($_POST['format']) && !empty($_POST['stars'])){
    require_once 'param.php';
    $query = "INSERT INTO films_table(title, release_year, format, stars) VALUES ('{$_POST['name']}', '{$_POST['release_year']}', '{$_POST['format']}', '{$_POST['stars']}')";

    mysqli_query($dbc, $query) or die('Query Error');

    echo 'Добавление успешно';
}else{
    echo 'Добавление не успешно';
}
?>
</body>
</html>