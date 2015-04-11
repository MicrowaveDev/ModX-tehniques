<?php
/**
Сниппет для вывода существительного, склоняющегося относительно какойто цифры,
например: "1 студент", "5 студентов" и "4 студента" имеют разные формы слова "студент"
@param int $number, string $one, string $two, string $five
@return string
Как использовать:
[[enducement? &number=`[[*count]]` &one=`студент` &two=`студента` &five=`студентов`]]
или
[[*count:enducement=`студент,студента,студентов`]]
*/
$c = $input ? $input : $number;
if((!empty($input) || $input === 0) && !empty($options)){
   $words = explode(',', $options);
   $one = $words[0];
   $two = $words[1];
   $five = $words[2];
}
$c = abs($c);
$c %= 100;
if ( ($c >= 5) and ($c <= 20) ) :
    return $five;
endif;
$c %= 10;
if ($c == 1) :
    return $one;
endif;
if ( ($c >= 2) and ($c <= 4) ) :
    return $two;
endif;
return $five;
