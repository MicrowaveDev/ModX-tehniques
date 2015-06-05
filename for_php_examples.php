# получить ресурс по id
$document = $modx->getObject('modResource', $id);

# получить первый ресурс из выборки по условию
$document = $modx->getObject('modResource',array(
    'published' => 1,
    'pagetitle' => 'Телефоны'
));

# выборка ресурсов по TV
$c = $modx->newQuery('modResource');
$c->innerJoin('modTemplateVarResource','TemplateVarResources');
$c->innerJoin('modTemplateVar','TemplateVar','`TemplateVar`.`id` = `TemplateVarResources`.`tmplvarid`');
$c->where(array(
        'TemplateVar.name:IN' => array('beginDate','endDate'),
        'TemplateVarResources.value:>=' => $firstDate,
        'TemplateVarResources.value:<=' => $lastDate,
        'modResource.template' => 4
    ));
$events = $modx->getCollection('modResource',$c);

/* get the extended field named "color": */
$fields = $profile->get('extended');
$color = $fields['color'];
/* set the color field to red */
$profile->set('extended',$fields);
$profile->save();

# Начало работы с кастомным пакетом, например созданным в MIGX
$modx->addPackage('customPackage',MODX_BASE_PATH.'core/components/customPackage/model/','modx_');

# Создание запроса и поиск по TV
$c = $modx->newQuery('modResource');
$c->where(array(
        'TemplateVar.name:IN' => array('beginDate','endDate'),
        'TemplateVarResources.value:>=' => $firstDate,
        'TemplateVarResources.value:<=' => $lastDate,
        'modResource.template' => 4
   ));
$c->sortby('id','DESC');

$lastuser = $modx->getObject('modResource', $c);

# Создание ресурса
$resource = $modx->newObject('modResource');
$resource->fromArray(array('pagetitle'=>'Заголовок ресурса', 'publishedon'=> date("Y-m-d H:i:s")));
$resource->save();
return $resource->get('id');
