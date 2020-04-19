<?php
function twoSum(array $list, int $k)
{
    foreach ($list as $element) {
        $temp = $k - $element;
        if (array_search($temp, $list)) {
            return true;
        }
    }
    return false;
}

$list = [4, 7, 1, -3, 2];
$k = 5;

var_dump(twoSum($list, $k)); // bool(true)
