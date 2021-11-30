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
<form method="post" action="main.php" enctype="multipart/form-data">
    <label>Выберите файл</label><br>
    <input type="file" name="text_file"><br>
    <input type="submit" name="send" value="SEND">
</form>
<?php
}elseif (isset($_POST['send'])){
    require_once 'param.php';
    if ($_FILES['text_file']['error']==0){
        move_uploaded_file($_FILES['text_file']['tmp_name'], "file/{$_FILES['text_file']['name']}");
        $query = "INSERT INTO files(name_file) VALUE ('{$_FILES['text_file']['name']}')";
        mysqli_query($dbc, $query) or die('Query Error');
    }
    echo 'Загрузка успешная';
}else{
    echo 'Загрузка не успешная';
}
?>
</body>
</html>