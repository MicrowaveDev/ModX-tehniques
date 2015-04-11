@EVAL
$output = $modx->runSnippet('getResources',array(
   'context'=>$modx->resource->getOne('Context')->key,
   'parents'=>'0',
   'where'=>'{
	   "published:=": 1,
	   "parent:=": 0,
	   "id:!=":237,
	   "AND:id:!=":1
	}',
'tpl'=>'@INLINE [[+pagetitle]]==[[+id]]',
'outputSeparator'=>'||',
'sortby'=>'menuindex',
'sortdir'=>'ASC',
'limit'=>'0',
'showHidden'=>true));
return '- Select resource==||' . $output;
