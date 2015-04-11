@EVAL
$output = $modx->runSnippet('getImageList',array(
'tvname'=>'migx-faq',
'docid'=>$modx->resource->get('id'),
'tpl'=>'@CODE:[[+title]]==[[+MIGX_id]]',
'outputSeparator'=>'||'));
return '- Choice table row==||' . $output;
