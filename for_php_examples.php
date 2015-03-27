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
