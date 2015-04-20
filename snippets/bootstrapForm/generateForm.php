<?php
# [[generateFormFields? &names=`[[*multi-reg-fields?]]` &required=`[[*multi-reg-required-fields?]]`]]
if(!$names)
    return;

$fields = explode(',', $names);

$req_fields = array();
if($required)
    $req_fields = explode(',', $required);

$output = "";
foreach($fields as $field){
    if($field != 'faculty')
        $output .= $modx->runSnippet('formField', array('name' => $field, 'required' => in_array($field, $req_fields)));
    else
        $output .= $modx->runSnippet('formSelectField', array('name' => $field,
                                                            'required' => in_array($field, $req_fields),
                                                            'template' => 36));
}
return $output;
