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
if (isset($_GET['id']) && !empty($_GET['id'])){
    require_once 'param.php';
    $query = "SELECT title, release_year, format, stars FROM films_table WHERE id=".$_GET['id'];
    $res = mysqli_query($dbc, $query) or die('Query Error');

    while ($next=mysqli_fetch_array($res)){
        echo "<div>
                <h3>Название - {$next['title']}</h3>
                <p>Год выпуска - {$next['release_year']}</p>
                <p>Формат - {$next['format']}</p>
                <div>Актёры - {$next['stars']}</div>
                <div><a href='delete.php?id={$_GET['id']}'>Удалить</a></div>
              </div>";
    }
}else{
    echo 'Нету айди фильма';
}
?>
</body>
</html>