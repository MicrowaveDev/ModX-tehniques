<?php
$request_id = $_GET['id'] || $_POST['id'];

$resource = $modx->getObject('modResource', $id || $request_id);
$props = $resource->toArray();
$modx->setPlaceholders($resource, $namespace || 'rtp.');
