<?php
$namespace = 'profcom';
$labelColMd = 4;
$labelColLg = 3;
$forFormIt = true;

$minusInputCol = 2;

$inputColMd = 12 - $labelColMd - $minusInputCol;
$inputColLg = 12 - $labelColLg - $minusInputCol;

$labelClasses = 'col-md-' . $labelColMd . ' col-lg-' . $labelColLg;
$inputClasses = 'col-md-' . $inputColMd . ' col-lg-' . $inputColLg;

if(!$label){
    $modx->lexicon->load($namespace.':default');
    $label = $modx->lexicon('reg.' . $name);
}

$label =   '<div class="' . $labelClasses . ' text-right">' .
                '<label for="' . $name . '">' . $label . '</label>' .
            '</div>';


$field = $label . '<div class="' . $inputClasses . '">';

$nameAdder = '';
if($required && $forFormIt)
    $nameAdder = ':required';

$field .= '<select ' .
            'name="' . $name . $nameAdder . '" ' .
            'class="form-control ' . $classes . '" ';

if($required)
   $field .= 'required ';

$field .= '>';

$resources = $modx->getCollection('modResource', array('template' => $template));

$field .= '<option value="">'.$modx->lexicon('reg.not_select').'</option>';
foreach($resources as $res){
   $field .= '<option value="'.$res->get('id').'">'.$res->get('pagetitle').'</option>';
}

$field .= '</select>';
$field .= '</div>';

return '<div class="form-group col-md-12">' . $field . '</div>';
