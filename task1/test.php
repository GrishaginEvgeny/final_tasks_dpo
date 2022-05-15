<?php
$inputFiles = glob('data/*.dat');
$outputFiles = glob('data/*.ans');
require_once "task.php";
$answer_data_pairs = array_combine($inputFiles,$outputFiles);
$index = 1;
foreach ($answer_data_pairs as $input => $output){
    $flag = true;
    $data = getData($input);
    $my_answ = getMyAnswer($data);
    $prog_anws = getGoodAnswer($output);
    for($i=1; $i<count($my_answ)+1; $i=$i+1){
        $my_answ[$i-1] == $prog_anws[$i-1] ? $flag = true : $flag = false;
    }
    $flag ? print_r("{$index}.OK\n") : print_r("{$index}.Wrong\n");
    $index = $index + 1;
}