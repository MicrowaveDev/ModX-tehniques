<?php
# endDateStr
# beginDateStr
# или один из них

if(!$endDateStr)
    $endDateStr = date("Y-m-d H:i:s");
if(!$beginDateStr)
    $beginDateStr = date("Y-m-d H:i:s");

if(intval(strftime('%e' ,strtotime($endDateStr))) > intval(strftime('%e' ,strtotime($beginDateStr)))) {
    $endDateStr = strftime('%Y-%m-%d 23:59:59', strtotime($endDateStr));
    $beginDateStr = strftime('%Y-%m-%d 00:00:00', strtotime($beginDateStr));
}

$difference = strtotime($endDateStr) - strtotime($beginDateStr);

$periods = array();

// 1 *1
$periods[1] = array('секунду', 'минуту', 'час', 'день', 'неделю', 'месяц', 'год');
// 2-4 *2-*4
$periods[2] = array('секунды', 'минуты', 'часа', 'дня', 'недели', 'месяца', 'года');
// 5-20  *5-*0
$periods[3] = array('секунд', 'минут', 'часов', 'дней', 'недель', 'месяцев', 'лет');

$lengths = array(60, 60, 24, 7, 4.35, 12, 10);

for ($j = 0; $difference >= $lengths[$j]; $j++) {
    $difference /= $lengths[$j];
    if ($j > 5) {
        break;
    }
}

$difference = round($difference);


// выбираем нужный ключ массива $periods по окончанию итогового числа
if ($difference == 1)
    $i = 1;
elseif ($difference >= 2 && $difference <= 4)
    $i = 2;
elseif ($difference >= 5 && $difference <= 20)
    $i = 3;
elseif ($difference > 20) {
    $ch = substr($difference, 1);

    if ($ch == 1)
        $i = 1;
    elseif ($ch >= 2 && $ch <= 4)
        $i = 2;
    else
        $i = 3;
}

return $difference . ' ' . $periods[$i][$j];
