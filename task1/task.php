<?php
function getData($file_path): ?array {
    $file=fopen($file_path, 'r');
    $array_of_dates_by_id = [];
    while(!feof($file)){
        $line = fgets($file);
        $data = explode("\t", $line);
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

function getGoodAnswer($file_path): ?array {
    $result = array();
    $file=fopen($file_path, 'r');
    while(!feof($file)) {
        $line = fgets($file);
        array_push($result, $line);
    }
    return $result;
}

function getMyAnswer($array_of_data):?array {
    $result = array();
    foreach ($array_of_data as $key => $adv){
        array_push($result, (count($adv)-1).' '.$key.' '.$adv['last_date']);
    }
    return $result;
}

//$array = getInputFile('data/3.dat');

