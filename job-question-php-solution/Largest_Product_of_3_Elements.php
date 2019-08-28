<?php

function maximum_product_of_three(array $nums)
{
    $nums_duplicate = $nums;
    $max1 = max($nums);
    remove($max1, $nums);
    $max2 = max($nums);
    remove($max2, $nums);
    $max3 = max($nums);
    remove($max3, $nums);
    $min1 = min($nums_duplicate);
    remove($min1, $nums_duplicate);
    $min2 = min($nums_duplicate);
    return max($max1 * $max2 * $max3, $max1 * $min1 * $min2);
}

function remove(int $needle, array &$haystack){
    $key = array_search($needle, $haystack);
    unset($haystack[$key]);
}

echo maximum_product_of_three([1, 2, 3]) . "\n";
// 6
echo maximum_product_of_three([-1, -2, -3]) . "\n";
// -6
echo maximum_product_of_three([1, 2, 3, 4, 5]) . "\n";
// 60
echo maximum_product_of_three([-1, -2, -3, -4, -5]) . "\n";
// -6
echo maximum_product_of_three([1, 2, -3, -4, -5]) . "\n";
// 40
echo maximum_product_of_three([-1, 2, 3, -4, -5]) . "\n";
// 60
echo maximum_product_of_three([-1, -2, 3, 4, -5]) . "\n";
// 40
echo maximum_product_of_three([-1, -2, -3, 4, 5]) . "\n";
// 30
echo maximum_product_of_three([1, 2, 3, -4, -5]) . "\n";
// 60
echo maximum_product_of_three([-1, 2, 3, 4, -5]) . "\n";
// 24
echo maximum_product_of_three([-1, -2, 3, 4, 5]) . "\n";
// 60
echo maximum_product_of_three([0, 1, 2]) . "\n";
// 0
echo maximum_product_of_three([0, 0, 1, 2]) . "\n";
// 0
echo maximum_product_of_three([0, 0, 0, 1]) . "\n";
// 0
echo maximum_product_of_three([0, 1, 2, 3]) . "\n";
// 6
echo maximum_product_of_three([0, 0, 1, 2]) . "\n";
// 0
echo maximum_product_of_three([-4, 0, 1, 2]) . "\n";
// 0
echo maximum_product_of_three([-4, -3, 0, 1]) . "\n";
// 12
echo maximum_product_of_three([-4, -3, -2, 0]) . "\n";
// 0
echo maximum_product_of_three([-4, -3, 0, 3, 4]) . "\n";
// 48
echo maximum_product_of_three([-4, -4, 2, 8]) . "\n";
// 128