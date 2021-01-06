<?php

$numbers = new Ds\Vector([1, 2, 3, 4, 5]);

// somme des carrés positifs
$result = $numbers
    ->map(fn($value) => pow($value, 2))
    ->filter(fn($value) => $value % 2 === 0)
    ->reduce(fn($sum, $value) => $sum + $value)
;

var_dump($result); // =20 car 4 et 16 sont les seuls conservés
