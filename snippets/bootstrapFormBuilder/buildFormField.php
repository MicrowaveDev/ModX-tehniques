<?php
# [[!buildFormField? &name=`phone` &type=`tel`]]
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
    $lex = $name ? $name : $type;
    $label = $modx->lexicon('reg.' . $lex);
}

$labelDiv =   '<div class="' . $labelClasses . ' text-right">' .
                '<label for="' . $name . '">' . $label . '</label>' .
            '</div>';

if(!$type) {
    switch($name){
        case "number":
        case "count":
           $type = "number";
           break;
        case "email":
           $type = "email";
           break;
        case "phone":
           $type = "tel";
           break;
        default:
           $type = "text";
    }
}

if($type != "submit"){
    if($type == "tel"){
        $classes .= ' bfh-phone';
    }

    $field = $labelDiv . '<div class="' . $inputClasses . '">';

    $nameAdder = '';
    if($required && $forFormIt)
       $nameAdder = ':required';

    $field .= '<input ' .
                'type="' . $type . '" ' .
                'name="' . $name . $nameAdder . '" ' .
                'value="' . $value . '" ' .
                'placeholder="' . $placeholder . '" ' .
                'class="form-control ' . $classes . '" ';

    if($required)
       $field .= 'required ';

    switch($type){
        case "tel":
            $field .= 'data-format="8 (ddd) ddd-dddd" ' .
                'minlength="16" ';
            break;
        default:
            //nothing
            break;
    }
    $field .= '>';
    $field .= '</div>';
} else {
    $inputClasses .= ' col-md-offset-' . $labelColMd . ' col-lg-offset-' . $labelColLg;
    $field .=   '<div class="' . $inputClasses . '">' .
                    '<button type="submit" class="btn btn-primary">' . $label . '</button>'.
                '</div>';
}
return '<div class="form-group col-md-12">' . $field . '</div>';
