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

<form method="get" action="indexfilms.php">
    <label>По имени</label><input type="radio" value="name" name="cid"><label>По актёру</label><input value="actors" type="radio" name="cid"><br>
    <input type="text" name="search"><input type="submit" name="serch" value="Найти">
</form>
<?php
require_once 'param.php';
$query = "SELECT id, title, release_year, format, stars FROM films_table";

    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        switch ($sort) {
            case 'ASC':
                $sort = "DESC";
                break;
            case 'DESC';
                $sort = "ASC";
                break;
            default:
                $sort = "DESC";
                break;
        }
        $query.=" ORDER BY title $sort";
    }
    echo '<a href="indexfilms.php?sort='.$sort.'">Отсортировать по именю</a>';

    if (isset($_GET['search']) && !empty($_GET['search'])){
        $search1 = $_GET['search'];
        $search1 = explode(' ', $search1);
        $words = str_replace(',', ' ', $search1);
    }

    $arr_words = array();
    if (count($words) > 0){
        foreach ($words as $tmp){
            if (!empty($tmp)){
                $arr_words[] = $tmp;
            }
        }
    }

    $final_words = array();
    if (count($arr_words)>0){
        foreach ($arr_words as $tmp){
            if (isset($_GET['cid']) && $_GET['cid']=='actors'){
                array_push($final_words, " stars LIKE '%$tmp%' ");
            }elseif (isset($_GET['cid']) && $_GET['cid']=='name'){
                array_push($final_words, " title LIKE '%$tmp%' ");
            }
        }
    }

    $result_words = implode('OR', $final_words);
    if (!empty($result_words)){
        $query.=" WHERE $result_words";
    }
?>
<table border="1">
    <tr>
        <th>№</th>
        <th>Название</th>
        <th>Полная информация</th>
    </tr>
    <?php
    $res = mysqli_query($dbc, $query) or die('Query Error');

    $n = 1;
    while ($next=mysqli_fetch_array($res)){
        echo "<tr>
                <td>{$n}</td>
                <td>{$next['title']}</td>
                <td><a href='info.php?id={$next['id']}'>Подробнее</a></td>
              </tr>";
        $n++;
    }
    ?>
</table>
</body>
</html>