<?php
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $children_ids = $modx->getChildIds(intval($_POST['parent']), $_POST['depth'], array('context' => 'web'));
    $children = $modx->getCollection('modResource', array('id:IN' => $children_ids, 'template'=>intval($_POST['template'])));
    $result = [];
    foreach($children as $child){
       $result[$child->get('id')] = $child->get('pagetitle');
    }
    return $modx->toJSON($result);
}
