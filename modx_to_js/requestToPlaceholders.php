<?php
if($_REQUEST){
    $placeholders = $_REQUEST;

    $toArray = array('region' => 'regions', 'city' => 'cities', 'lang' => 'langs');
    $like = array('lang');
    foreach($toArray as $name => $multiple_name){
        if(!empty($_REQUEST[$multiple_name])){

            $json = $modx->toJSON($_REQUEST[$multiple_name]);
            $placeholders[$multiple_name] = str_replace (' ', '', $json);

            #Дополнительно: фильтрация для getResources tvFiltres
            foreach($_REQUEST[$multiple_name] as $key => $value){

                $val = $_REQUEST[$multiple_name][$key];

                if(in_array($name, $like))
                    $val = '%'.$val.'%';

                if($key===0){
                    $placeholders[$multiple_name.'_filter'] = ','.$name.'==' . $val;
                }
                else{
                    $placeholders[$multiple_name.'_filter'] = $placeholders[$multiple_name.'_filter'] . '||'.$name.'==' . $val;
                }
            }
        }
    }

    $modx->setPlaceholders($placeholders, 'get.');
}
