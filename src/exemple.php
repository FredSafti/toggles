<?php

$collection = new Ds\Vector(['hey', 'crushme', 'popme']);

echo 'get first:' . $collection->get(0) . PHP_EOL;

echo 'pop:' . $collection->pop() . PHP_EOL;

$collection->set(1, 'crushed');
$collection->push('last word');

echo 'dump:';
var_dump($collection);

echo 'count:' . count($collection) . PHP_EOL;

foreach ($collection as $index => $value) {
    echo '    element ' . $index . ' = ' . $value . PHP_EOL;
}

echo 'json:' . json_encode($collection) . PHP_EOL;

echo 'empty ? ' . ($collection->isEmpty() ? 'yes' : 'no') . PHP_EOL;

echo 'toArray:';
var_dump($collection->toArray());
