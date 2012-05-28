Snippet: 		[[SnippetName]]
Chunk: 			[[$ChunkName]]
System Setting: [[++SettingName]]
TV: 			[[*fieldName/TvName]]
Link tag:		[[~PageId]]
Placeholder:	[[+PlaceholderName]]


<?php

/* always available objects */
$modx->resource;	// the current document
$modx->user;		// the current user

/* get a system setting */
$modx->getOption('SettingName'); // eg site_start

/* get simple chunk */
$modx->getChunk('ChunkName');

/* parse a chunk many times */
foreach ($docs as $doc) {
        $output .= $modx->getChunk('teaserTpl', $doc->toArray() );
    }
return $output;


/* Display a particular document */
$resource = $modx->getObject('modResource', array('pagetitle'=>'MyDocument')); // with properties
$resource = $modx->getObject('modResource', $resourceID); // with a document id
$output = '<p>Document:' . $resource->get('longtitle') . '</p>';
$output .= '<p>Content:' . $resource->get('content') . '</p>';

/* change a resource property */
$resource = $modx->getObject('modResource', $resourceID); // with a document id
$resource->set('template', 7);

/* To set a TV value for the current resource */
$tv = $modx->getObject('modTemplateVar',array('name'=>'tvName')); // get the required TV object by name (or id)
$tv->setValue($modx->resource->get('id'), $newValue); // set the new value and save it
$tv->save();

/* Get all active users */
$users = $modx->getCollection('modUser',
 array('active'=>'1'));
foreach ($users as $user) {
  $output .= '<p>Username: ' . $user->get('username') . '</p>';
}
return $output

/* get all published resources that have not been deleted */
$resources = $modx->getCollection('modResource',
 array('published'=>'1','deleted'=>'0'));
foreach($resources as $resource) {
   $output .= '<div class="resource"><p>Document:' .
      $resource->get('longtitle') . '</p>';
   $output .= '<p>Content:' . $resource->get('content') . '</p></div>';
}

/* Get the user object for the creator of the current document */
$user = $modx->resource->getOne('CreatedBy');
return $user->get('username');

/* Get the parent object of the current resource */
$parent = $modx->resource->getOne('Parent');
return $parent->get('pagetitle');

/* Get the child objects of the current resource */
$children = $modx->resource->getMany('Children');
foreach ($children as $child) {
 $output .= '<p>' . $child->get('pagetitle') . '</p>';
}

/* Publish a set of resources from a list of resource IDs */
$resourceIds = array('12, 23, 32, 45');
foreach ($resourceIds as $id) {
 $resource = $modx->getObject('modResource',$id);
 $resource->set('published', '1');
 $resource->save();
}

/* other xpdo object methods */
$object->get('fieldName');
$object->toArray();


/* log an error */
$elementName = '[SnippetName]';
$modx->log(modX::LOG_LEVEL_ERROR, $elementName.' Could not do something.');
// also:
// LOG_LEVEL_DEBUG
// LOG_LEVEL_INFO
// LOG_LEVEL_WARN


/* change the template of many documents with the same parent */
foreach ($modx->getIterator('modResource', array('parent' =>15)) as $res) { $res->set('template',5); $res->save(); }


?>
