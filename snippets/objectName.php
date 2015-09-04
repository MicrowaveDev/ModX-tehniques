<?php
# $id
# $class
$object = $modx->getObject($class, $id);
if($object)
	return $object->get('name');
