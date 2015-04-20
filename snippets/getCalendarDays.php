<?php
$month = $_GET['month'] == "-1" ? date('m') : $_GET['month'];

if($_GET['dir'] == "next")
    $month ++;
else if($_GET['dir'] == "prev")
    $month --;

if($month == 0)
    $month = 12;
else if($month == 13)
    $month = 1;

$year = date('o');

$firstDate = date_format(new DateTime($month . '/1/' . $year), 'Y-m-d');
$lastDay = date("t", strtotime($firstDate));
$lastDate = date_format(new DateTime($month . '/' . $lastDay . '/' . $year), 'Y-m-d');
$emptyDays = date('N',strtotime($firstDate)) - 1;


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
$eventsHash = array();
if($events):
    foreach($events as $event) {
        $endDate = $event->getTVValue('endDate');
        $beginDate = $event->getTVValue('beginDate');

        if($endDate > $lastDate)
            $endDate = $lastDate;

        $lastEventDate = strtotime($endDate);

        $curEventDate = strtotime($event -> getTVValue('beginDate'));
        $curEventDate = strtotime(date('Y-m-d', $curEventDate));
        while($curEventDate <= $lastEventDate){

            if(strftime('%Y-%m-%d', $curEventDate) >= $firstDate) {
                $date = new DateTime();
                $date->setTimestamp($curEventDate);

                $eventsHash[$date -> format('j')] = $event;
            }

            $curEventDate = strtotime('+1 day', $curEventDate);
        }
    }
endif;

$result = "";
for ($i = 1; $i <= $emptyDays; $i++) {
    $result .= '<div class="calendar-day">&nbsp;</div>';
}

for ($i = 1; $i <= $lastDay; $i++) {
    if($eventsHash[$i]){

        $rangeDates = $modx->runSnippet('DatesRangeStr',array('beginDateStr' => $eventsHash[$i] -> getTVValue('beginDate'),
                                                        'endDateStr' => $eventsHash[$i] -> getTVValue('endDate')));

        $result .= $modx->getChunk('CalendarDay', array('title' => $eventsHash[$i]->get('pagetitle'),
                                                        'eventType' => $eventsHash[$i]->get('parent'),
                                                        'date' => $rangeDates,
                                                        'day' => $i,
                                                        'id' =>$eventsHash[$i]->get('id'),
                                                        'isClose' => $eventsHash[$i]->get('hidemenu')
                                                        ));
    }
    else {
        $result .= $modx->getChunk('CalendarDay', array('eventType'=>'', 'day' => $i));
    }
}
setlocale(LC_ALL, 'ru_RU.UTF-8');
return json_encode(array ('content' => $result,
                            'monthNum' => $month,
                            'monthStr'=>strftime(php_uname('s') == 'FreeBSD' ? '%OB' : '%B', strtotime($firstDate))));
