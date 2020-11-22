<?php

function balance(string $a, string $b): string
{
    $needle = ['!', '?'];
    $replace = [2, 3];
    $sumA = array_sum(str_replace($needle, $replace, str_split($a)));
    $sumB = array_sum(str_replace($needle, $replace, str_split($b)));
    $result = '';
    if ($sumA - $sumB > 0) {
        $result = 'Left';
    } elseif ($sumA - $sumB < 0) {
        $result = 'Right';
    } else {
        $result = 'Balance';
    }
    
    return $result;
}
