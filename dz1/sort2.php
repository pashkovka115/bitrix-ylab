<?php

// 1) У вас есть массив. Необходимо отсортировать его по PRICE

$array = [
    'SKLAD1' => [
        'EDA' => [
            'TOVAR1' => [
                'NAME' => '....',
                'PRICE' => 12343
            ],
            'TOVAR2' => [
                'NAME' => '....',
                'PRICE' => 12344
            ],
        ],
        'NAPITKI' => [
            'TOVAR55' => [
                'NAME' => '....',
                'PRICE' => 12346
            ],
            'TOVAR54' => [
                'NAME' => '....',
                'PRICE' => 12345
            ],
        ],
    ],

    'SKLAD2' => [
        'EDA' => [
            'TOVAR66' => [
                'NAME' => '....',
                'PRICE' => 12347
            ],
            'TOVAR67' => [
                'NAME' => '....',
                'PRICE' => 12341
            ],
        ],
        'NAPITKI' => [
            'TOVAR77' => [
                'NAME' => '....',
                'PRICE' => 12340
            ],
            'TOVAR78' => [
                'NAME' => '....',
                'PRICE' => 12342
            ],
        ],
    ],
];


function cmp($a, $b, $field = 'PRICE')
{
    if ($a[$field] == $b[$field]) {
        return 0;
    }
    return ($a[$field] < $b[$field]) ? -1 : 1;
}



function mysort($a)
{
    $new_a = [];

    foreach ($a as $val1){
        foreach ($val1 as $val2){
            foreach ($val2 as $key3 => $val3){
                $new_a[$key3] = $val3;
            }
        }
    }
    usort($new_a, 'cmp');

    return $new_a;
}


echo '<pre>'; print_r(mysort($array)); echo '</pre>';
