<?php
# [[!counter? &generate=`[[+bool]]`]]
if(!$generate)
    return;

$counter = $modx->getOption('counter');
if(!$counter)
    $counter = 1;

$modx->setOption('counter', $counter + 1);

return $counter;
