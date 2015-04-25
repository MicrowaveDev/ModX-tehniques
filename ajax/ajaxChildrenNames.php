<?php
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $context = $_POST['context'] ? $_POST['context'] : 'web';
    $depth = ($_POST['depth'] || $_POST['depth'] === 0) ? $_POST['depth'] : 2;

    $children_ids = $modx->getChildIds(intval($_POST['parent']), $depth, array('context' => $context));
    $children = $modx->getCollection('modResource', array('id:IN' => $children_ids, 'template' => intval($_POST['template'])));
    $result = [];
    foreach($children as $child){
       $result[$child->get('id')] = $child->get('pagetitle');
    }

    return $modx->toJSON($result);
}
