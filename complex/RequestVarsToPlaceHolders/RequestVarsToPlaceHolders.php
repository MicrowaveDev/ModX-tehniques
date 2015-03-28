<?php
if($_GET){
    $placeholders = $_GET;
    //in here may be done something like this:
    //$placeholders['published'] = $_GET['published'] ? $_GET['published'] : 1;

    //for example:
    //<div>
    //  <label><input type="checkbox" value="89" name="cities[]"> Акра</label>
    //  <label><input type="checkbox" value="90" name="cities[]" checked="checked"> Нагария</label>
    ///</div>
    $toArray = array('city' => 'cities', 'lang' => 'langs');
    //cities - name of input
    //city - name of tv fo filter
    $like = array('lang');
    //$like - an array of tv names for filter LIKE logic. For example: lang==%en%
    foreach($toArray as $name => $multiple_name){
        if(!empty($_GET[$multiple_name])){

            $json = $modx->toJSON($_GET[$multiple_name]);
            $placeholders[$multiple_name] = str_replace (' ', '', $json);
            //$placeholders[$multiple_name] - placeholder to place JSON to hidden input. For example:
            //<input type="hidden" id="get-cities" value='[[+get.cities]]'/> ===> <input type="hidden" id="get-cities" value="["90","88"]">

            foreach($_GET[$multiple_name] as $key => $value){

                $val = $_GET[$multiple_name][$key];

                if(in_array($name, $like))
                    $val = '%'.$val.'%';

                if($key===0){
                    $placeholders[$multiple_name.'_filter'] = ','.$name.'==' . $val;
                }
                else{
                    $placeholders[$multiple_name.'_filter'] = $placeholders[$multiple_name.'_filter'] . '||'.$name.'==' . $val;
                }
            }
            //as example of result $placeholders[$multiple_name.'_filter'] : ,city==90||city==88
            //applicable for getResources tvFilters: http://rtfm.modx.com/extras/revo/getresources
        }
    }

    $modx->setPlaceholders($placeholders, 'get.');
}
