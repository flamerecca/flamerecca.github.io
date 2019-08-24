<?php

function moveZeros(array &$nums)
{
    $start = 0;
    $end = 0;
    foreach($nums as $key => $num) {
        if ($num == 0) {
            $start++;
        } else {
            $temp = $nums[$start];
            $nums[$start] = $nums[$end];
            $nums[$end] = $temp;
            $start++;
            $end++;
        }
    }
}

$nums = [0, 0, 0, 2, 0, 1, 3, 4, 0, 0];
moveZeros($nums);
var_dump($nums);
// [2, 1, 3, 4, 0, 0, 0, 0, 0, 0]