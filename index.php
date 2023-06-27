<?php

require_once 'Convolution.php';

$kernel = array(
    array(0, 0, 0),
    array(0, 1, 0),
    array(0, 0, 0),
);
$conv = new convolution("image.png", $kernel);

$conv->createImage(
    "result.png",
    $conv->convolution($conv->r_array),
    $conv->convolution($conv->g_array),
    $conv->convolution($conv->b_array),
    $conv->convolution($conv->a_array)
);