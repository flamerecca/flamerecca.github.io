<?php

function findKthLargest(array $list, int $k)
{
    $maxHeap = new SplMaxHeap();
    foreach ($list as $element) {
        $maxHeap->insert($element);
    }
    for ($i = 0; $i < $k - 1; $i++) {
        $maxHeap->extract();
    }
    return $maxHeap->current();
}

$list = [3, 5, 2, 4, 6, 8];
$k = 3;

echo findKthLargest($list, $k);
// 5