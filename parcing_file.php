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

    $query = "SELECT name_file, status FROM files WHERE id=".$_GET['id']." AND status=0";
    $res = mysqli_query($dbc, $query) or die('Query Error');
    $next = mysqli_fetch_array($res);

//    echo "<div>
//            <h3>{$next['name_file']}</h3><br>
//          </div>";
    $file_name = $next['name_file'];

    if (file_exists('file/'.$file_name)){//Функция file_exist возвращает тру если файл нафодиться на хостинге в указанном месте
        //$resFile = file_get_contents('file/'.$file_name);//file_get_contents считывает содержимое файла в виде сплошной строки
        //file_put_contents() - добавляет информацию в файл

        $resFile = file('file/'.$file_name);//считівает файл построчно  и возвращает массив строк
        //print_r($resFile);
        $str_film = array();
        if (count($resFile)>0){
            foreach ($resFile as $tmp){
                if ($tmp != "\n"){//избавляемся от пустих строк символа перевода каретки
                    $str_film[] = $tmp;
                }
            }
        }

        $res_film = array();
        if (count($str_film)>0){
            foreach ($str_film as $tmp){
                //$title = explode(':',$tmp); функция експлод не подходит изза двуиточия в названии

                //echo strpos($tmp, ':').'<br>'; strpos - функция стрпос возвращает номер (индекс) символа которій встречаеться с начала строки
                //В данном случаии мы определяем индекс(положение) ':' с начала строки
                $title = substr($tmp, 0, strpos($tmp, ':'));//substr - функция возвращает подстроку тоесть вырезает со строки апределённое количество символов и имеет параметри - (1.Строка с которой вирезаем контент, 2.Индекс символа с которого вырезаем, 3.Количество символов которые вырезаем)
                //Если 3го параметра нет то вырезаеться всё до конца строки
                $content = substr($tmp, strpos($tmp, ":")+1);
                //echo $title.$content.'<br>';

                $res_film[] = array($title=>$content);//сохраняем в массиве маленькие асоциативние массиві под каждое поле
            }
        }
        //print_r($res_film);
        $finish_arr = array();
        if (count($res_film)>0){
            for ($i = 0; $i < count($res_film); $i+=4){
                $finish_arr[] = array_merge($res_film[$i], $res_film[$i+1], $res_film[$i+2], $res_film[$i+3]);
                //array_merge - делает с нескольких массивов делает один
            }
        }
        //print_r($finish_arr);

        if (count($finish_arr)>0){
            for ($i = 0; $i < count($finish_arr); $i++) {
                $queryAddFilm = "INSERT INTO films_table(title, release_year, format, stars) VALUES ('{$finish_arr[$i]['Title']}', '{$finish_arr[$i]['Release Year']}', '{$finish_arr[$i]['Format']}', '{$finish_arr[$i]['Stars']}')";
                //echo $queryAddFilm;
                mysqli_query($dbc, $queryAddFilm) or die('Query Error Add film');
                echo 'Loading...<br>';
            }
        }
        echo 'Loading Success!!!';
        $queryUpdate = "UPDATE files SET status=1 WHERE name_file='$file_name'";
        echo $queryUpdate;
        mysqli_query($dbc, $queryUpdate) or die('Query Update');
    }
}
?>
</body>
</html>