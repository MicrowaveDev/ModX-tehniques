<?php
# options - main fields
# tvs - tv fields

$resource = $modx->newObject('modResource');
$resource->fromArray($options);
$resource->setContent($content);
$resource->save();

foreach($tvs as $tvname => $tvvalue){
    $tv = $modx->getObject('modTemplateVar',array('name'=> $tvname));
    $tv->setValue($resource->get('id'), $tvvalue);
    $tv->save();
}

return $resource->get('id');
