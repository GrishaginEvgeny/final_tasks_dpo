<?php
//получение ответов из файла .ans
function getGoodAnswer($file_path): ?array {
    $result = array();
    $file=fopen($file_path, 'r');
    while(!feof($file)) {
        $line = fgets($file);
        $data = explode(" ", $line);
        array_push($result, [
            'name' => $data[0],
            'weight' =>  round(floatval(trim($data[1])),5),
        ]);
    }
    return $result;
}

//получение данных их .dat
function getData($file_path): ?array {
    $result = [];
    $file = fopen($file_path, 'r');
    while(!feof($file))
    {
        $line = fgets($file);
        $data = explode(" ", $line);
        array_push($result, [
            'name' => $data[0],
            'weight' => round(floatval(trim($data[1])),5),
        ]);
    }
    return $result;
}

//сумма весов всех реклам
function getSumByArray($ads_data): ?float
{
    $count = 0;
    foreach ($ads_data as $ad) $count = $count + $ad["weight"];
    return round($count,5);
}

//эмулияция позкывания рекламы, возвращает массив с долей показов, каждой рекламы, где ключ имя рекламы
function showAds($ads_data):?array{
    $result = [];
    $countByArray = getSumByArray($ads_data);
    foreach ($ads_data as $ad){
        $result[$ad['name']] =  round(1.0 / ($countByArray / $ad["weight"]),5);
    }
    return $result;
}
