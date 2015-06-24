<?php
# tpl
# id
# includeCurrent
# untilParent
# example: [[!breadCrumbs? &tpl=`GeneralListItem` &includeCurrent=`0`]]

$includeCurrent = $modx->getOption('includeCurrent', $scriptProperties, 1);

if(!$id)
    $parent = $includeCurrent ? $modx->resource : $modx->getObject('modResource', $modx->resource->get('parent'));
else
    $parent = $modx->getObject('modResource', $id);

if(!$parent || !$tpl)
    return;

$output = '';
while($parent){
    $output = $modx->getChunk($tpl, $parent->toArray()) . $output;

    $parentId = $parent->get('parent');
    if($untilParent != $parentId)
        $parent = $modx->getObject('modResource', array('id'=>$parentId));
    else
        $parent = '';
}

return $output;
