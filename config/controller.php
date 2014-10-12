<?php
use Phalcon\Mvc\Micro\Collection as MicroCollection;

$index = new MicroCollection();

$index->setHandler(new IndexController());

//Use the method 'index' in IndexController
$index->get('/', 'index');

$app->mount($index);