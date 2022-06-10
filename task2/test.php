<?php
$inputFiles = glob('data/*.dat');
$outputFiles = glob('data/*.ans');
require_once "task.php";
$answer_data_pairs = array_combine($inputFiles,$outputFiles);
$index = 1;
foreach ($answer_data_pairs as $input => $output){
    $flag = true;
    $my_answ = getResult($input);
    $prog_anws = getGoodAnswer($output);
    for($i=0; $i<count($my_answ); $i=$i+1){
        trim($my_answ[$i]) == trim($prog_anws[$i]) ? $flag = true : $flag = false;
    }
    $flag ? print_r("{$index}.OK\n") : print_r("{$index}.Wrong\n");
    $index = $index + 1;
}