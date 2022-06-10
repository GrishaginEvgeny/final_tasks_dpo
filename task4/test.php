<?php
//Получение ресурсов файлов
$inputFiles = glob('data/*.dat');
$outputFiles = glob('data/*.ans');
//получаем доступ к файлу решения
require_once "task.php";
//массив, где ключ, имя входного файла, а знечение выходного
$answer_data_pairs = array_combine($inputFiles,$outputFiles);
$index = 1;
//цикл проверки верности ответов
foreach ($answer_data_pairs as $input => $output){
    $flag = true;
    $data = getData($input);
    $my_answ = showAds($data);
    $prog_anws = getGoodAnswer($output);
    for($i=1; $i<count($my_answ)+1; $i=$i+1){
        ($my_answ[$prog_anws[$i-1]["name"]] - $prog_anws[$i-1]["weight"]) < 0.0005 ? $flag = true : $flag = false;
        if(!$flag) break;
    }
    $flag ? print_r("{$index}.OK\n") : print_r("{$index}.Wrong\n");
    $index = $index + 1;
}