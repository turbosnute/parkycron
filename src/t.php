<?php

echo date("Y-m-d");

echo "<hr>";


$string = "/permit/product/variant?variantId=5901db24-d330-4f9e-934a-1e1623d3d1f5";

echo preg_match("/\?variantId\=(.+)$/", $string, $matches);

echo "<hr>";

echo $matches[1];
?>
