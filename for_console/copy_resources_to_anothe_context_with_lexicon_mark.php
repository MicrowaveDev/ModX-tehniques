<?php
$from = array(  'context_key'=>'web',
                'cultureKey'=>'ru');

$target = array('context_key'=>'english',
                'cultureKey'=>'en',
                'mark' => ' [EN]');

function getBabelTV($modx){
    return $modx->getObject('modTemplateVar',array('name'=>'babelLanguageLinks'));
}
function babelTVtoArray($str){
    if(!$str)
        return array();

    $result = array();
    $contexts = explode(';', $str);
    foreach($contexts as $context){
        $obj = explode(':', $context);
        $result[$obj[0]] = $obj[1];
    }
    return $result;
}
function arrayToBabelTV($arr){
    $new_arr = array();
    foreach($arr as $key => $value){
       $new_arr[] = $key . ':' . $value;
    }
    return implode(';', $new_arr);
}
function getIdResourceInTarget($id, $modx, $target){
    $babelTV = getBabelTV($modx);
    $str = $babelTV->getValue($id);
    $babel = babelTVtoArray($str);
    if(!isset($babel[$target['context_key']]))
        return '';
    else return $babel[$target['context_key']];
}
function createResource($options, $tvs, $modx){
    $resource = $modx->newObject('modResource');

    $content = $options['content'];
    unset($options['content']);

    if(!$options['publishedon'])
        $options['publishedon'] = date("Y-m-d H:i:s");

    $resource->fromArray($options);
    $resource->setContent($content);
    $resource->save();

    foreach($tvs as $tvname => $tvvalue){
        $tv = $modx->getObject('modTemplateVar',array('name'=> $tvname));
        $tv->setValue($resource->get('id'), $tvvalue);
        $tv->save();
    }

    return $resource->get('id');
}
function copyResourceToTarget(&$resource, $modx, $from, $target){
    $babelTV = getBabelTV($modx);

    $id = $resource->get('id');
    $parent = $resource->get('parent');

    if($parent !== 0)
        $parent_in_target = getIdResourceInTarget($parent, $modx, $target);
    else
        $parent_in_target = 0;

    $modx->log(modX::LOG_LEVEL_ERROR, '[[INFO]] resource: ' . $id . ', parent: ' . $parent . ', parent_in_target: ' . $parent_in_target);

    if(!empty($parent_in_target) || $parent_in_target === 0){
        $modx->log(modX::LOG_LEVEL_ERROR, '[[COPY]] resource: ' . $id);
        $tvs = $resource->getMany('TemplateVars');
        $resource_tvs = array();
        foreach ($tvs as $tv) {
            $resource_tvs[$tv->get('name')] = $tv->getValue($id); //$tv->renderOutput($id);
        }
        $resource_tvs['babelLanguageLinks'] = $babelTV->getValue($id);

        $options = $resource->toArray();
        $options['parent'] = $parent_in_target;
        $options['context_key'] = $target['context_key'];
        $options['pagetitle'] = $options['pagetitle'] . $target['mark'];

        $new_id = createResource($options, $resource_tvs, $modx);
        $modx->log(modX::LOG_LEVEL_ERROR, '[[BABEL]] resource: ' . $resource_tvs['babelLanguageLinks']);
        $babelArr = babelTVtoArray($resource_tvs['babelLanguageLinks']);
        $babelArr[$from['context_key']] = $id;
        $babelArr[$target['context_key']] = $new_id;
        $babelStr = arrayToBabelTV($babelArr);

        $babelTV->setValue($id, $babelStr);
        $babelTV->setValue($new_id, $babelStr);
        $babelTV->save();
    }
    else{
        $modx->log(modX::LOG_LEVEL_ERROR, '[[COPY PARENT]] of resource: ' . $id . '(parent: '.$parent.')');
        if($parent !== 0)
            copyResourceToTarget($modx->getObject('modResource', $parent), $modx, $from, $target);

        copyResourceToTarget(&$resource, $modx, $from, $target);
    }
}

$resources = $modx->getCollection('modResource', array('context_key'=>$from['context_key']));

foreach($resources as $resource){
    $resource_in_target = getIdResourceInTarget($resource->get('id'), $modx, $target);

    if(empty($resource_in_target))
        copyResourceToTarget(&$resource, $modx, $from, $target);
}
return 'done';
