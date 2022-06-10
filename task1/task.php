<?php

//Возвращается массив, где ключами является id рекламы, а значение -- массив с самой поздней датой и массив с датами
function getData($file_path): ?array {
    $file=fopen($file_path, 'r');
    $array_of_dates_by_id = [];
    while(!feof($file)){
        $line = fgets($file);
        $data = explode("\t", $line);
        //если это первая реклама(т.е. ключа с такой рекламой нет, то такой ключ создаётся, если есть, то в массив по ключу добавляется элемент
        // и проверка на самое позднее время
        if(!array_key_exists(trim(strval($data[0])), $array_of_dates_by_id )){
            $array_of_dates_by_id[trim(strval($data[0]))] = [];
            array_push($array_of_dates_by_id[strval($data[0])], date_create_from_format("d.m.Y H:i:s", trim($data[1])));
            $array_of_dates_by_id[strval($data[0])]['last_date'] = trim($data[1]);
        }
        else {
            array_push($array_of_dates_by_id[strval($data[0])], date_create_from_format("d.m.Y H:i:s", trim($data[1])));
            if($array_of_dates_by_id[strval($data[0])]['last_date'] < date_create_from_format("d.m.Y H:i:s", trim($data[1]))){
                $array_of_dates_by_id[strval($data[0])]['last_date'] = trim($data[1]);
            }
        }
    }

    return $array_of_dates_by_id;
}

//Получение ответов из файла .ans
function getGoodAnswer($file_path): ?array {
    $result = array();
    $file=fopen($file_path, 'r');
    while(!feof($file)) {
        $line = fgets($file);
        array_push($result, $line);
    }
    return $result;
}

//получение ответов при помощи расчётов программы
function getMyAnswer($array_of_data):?array {
    $result = array();
    foreach ($array_of_data as $key => $adv){
        array_push($result, (count($adv)-1).' '.$key.' '.$adv['last_date']);
    }
    return $result;
}


