<?php
$patterns ="/ /"; 
$replace = "<br>"; 
print preg_replace($patterns, $replace, $input, 1);