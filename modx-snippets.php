Snippet: 		[[SnippetName]]
Chunk: 			[[$ChunkName]]
System Setting: 	[[++SettingName]]
TV: 			[[*fieldName/TvName]]
Link tag:		[[~PageId? &paramName=`value`]]
Placeholder:		[[+PlaceholderName]]


<?php

/* ***************************************** */
/* GLOBALS AND SETTINGS  */
/* ***************************************** */

/* always available objects */
$modx->resource;	// the current document
$modx->user;		// the current user

/* get a system setting */
$modx->getOption('SettingName'); // eg site_start


/* ***************************************** */
/* LOGGING  */
/* ***************************************** */

/* log an error */
$elementName = '[SnippetName]';
$modx->log(modX::LOG_LEVEL_ERROR, $elementName.' Could not do something.');
// also:  LOG_LEVEL_DEBUG, LOG_LEVEL_INFO, LOG_LEVEL_WARN

/* change target of logging */
$modx->setLogTarget('FILE'); // or ECHO
$target = array(
    'target' => 'FILE',
    'options' => array(
        'filename' => 'path_to_file'),
);
$modx->log(xPDO::LOG_LEVEL_ERROR, 'Error Message', $target);

/* change error level */
$modx->setDebug(E_ALL & ~E_NOTICE); // sets error_reporting to everything except NOTICE remarks
$modx->setLogLevel(modX::LOG_LEVEL_DEBUG);

// To report errors to the MODx error log:
trigger_error('...', E_USER_ERROR);


/* ***************************************** */
/* CHUNKS  */
/* ***************************************** */

/* get simple chunk */
$modx->getChunk('ChunkName');

/* parse a chunk many times */
foreach ($docs as $doc) {
        $output .= $modx->getChunk('teaserTpl', $doc->toArray() );
    }
return $output;

/* ***************************************** */
/* RESOURCES  */
/* ***************************************** */

/* Display a particular document */
$resource = $modx->getObject('modResource', array('pagetitle'=>'MyDocument')); // with properties
$resource = $modx->getObject('modResource', $resourceID); // with a document id
$output = '<p>Document:' . $resource->get('longtitle') . '</p>';
$output .= '<p>Content:' . $resource->get('content') . '</p>';

/* change a resource property */
$resource = $modx->getObject('modResource', $resourceID); // with a document id
$resource->set('template', 7);

/* get all published resources that have not been deleted */
$resources = $modx->getCollection('modResource',
 array('published'=>'1','deleted'=>'0'));
foreach($resources as $resource) {
   $output .= '<div class="resource"><p>Document:' .
      $resource->get('longtitle') . '</p>';
   $output .= '<p>Content:' . $resource->get('content') . '</p></div>';
}

/* Get the parent object of the current resource */
$parent = $modx->resource->getOne('Parent');
return $parent->get('pagetitle');

/* Get the child objects of the current resource */
$children = $modx->resource->getMany('Children');
foreach ($children as $child) {
 $output .= '<p>' . $child->get('pagetitle') . '</p>';
}



/* ***************************************** */
/* TVs  */
/* ***************************************** */


/* To set a TV value for the current resource */
$tv = $modx->getObject('modTemplateVar',array('name'=>'tvName')); // get the required TV object by name (or id)
$tv->setValue($modx->resource->get('id'), $newValue); // set the new value and save it
$tv->save();

/* to get a TV value for the current resource */
???

/* retrieve a number of TVs for resource */
$results = array();
$tvs = $modx->getCollection(
    'modTemplateVar',
    array("`name` IN (
        'image',
        'imageClass',
        'imageAlt',
        'imageCaption'
    )")
);
foreach ($tvs as $tv) {
	$results[$tv->get('name')] = (empty($processTVs) ? $tv->getValue($resourceId) : $tv->renderOutput($resourceId));
}
// render to a chunk of goodness
return $modx->getChunk('Picture.tpl',$results);


/* get all tvs for another resource */
$obj = $modx->getObject('modResource', array('name'=>'MyDoc'));
$id = $obj->get('id');
$tvs = $obj->getMany('TemplateVars');
foreach ($tvs as $tv) {
    $rawValue = $tv->getValue($id);
    $processedValue = $tv->renderOutput($id);
}

/* ***************************************** */
/* USERS  */
/* ***************************************** */

/* Get all active users */
$users = $modx->getCollection('modUser',
 array('active'=>'1'));
foreach ($users as $user) {
  $output .= '<p>Username: ' . $user->get('username') . '</p>';
}
return $output

/* Get the user object for the creator of the current document */
$user = $modx->resource->getOne('CreatedBy');
return $user->get('username');


/* Publish a set of resources from a list of resource IDs */
$resourceIds = array('12, 23, 32, 45');
foreach ($resourceIds as $id) {
 $resource = $modx->getObject('modResource',$id);
 $resource->set('published', '1');
 $resource->save();
}

/* ***************************************** */
/* XPDO  */
/* ***************************************** */

/* getObject  - get one table row */
/* getCollection - get many table rows */
/* getOne - get one related object */
/* getMany - get many related objects */
/* getCollectionGraph - ??? */


/* other xpdo object methods */
$object->get('fieldName');
$object->toArray();

/* change the template of many documents with the same parent */
foreach ($modx->getIterator('modResource', array('parent' =>15)) as $res) { $res->set('template',5); $res->save(); }




/* ***************************************** */
/* MODX SERVICES - EMAIL  */
/* ***************************************** */

/* send an email */

// first, get the email with the placeholders in it replaced by the snippet call.
// (Note the properties in the snippet call are in the array $scriptProperties.
// http://api.modx.com/revolution/2.1/_model_modx_mail_modmail.class.html
$message = $modx->getChunk('myEmail',$scriptProperties);
/* now load modMail, and setup options */
$modx->getService('mail', 'mail.modPHPMailer');
$modx->mail->set(modMail::MAIL_BODY,$message);
$modx->mail->set(modMail::MAIL_FROM,$scriptProperties['fromEmail']);
$modx->mail->set(modMail::MAIL_FROM_NAME,$scriptProperties['fromName']);
$modx->mail->set(modMail::MAIL_SENDER,$scriptProperties['fromName']);
$modx->mail->set(modMail::MAIL_SUBJECT,$scriptProperties['subject']);
$modx->mail->address('reply-to',$scriptProperties['fromEmail']);
$modx->mail->setHTML(true);
/* specify the recipient */
$modx->mail->address('to',$scriptProperties['toEmail']);
/* send! */
$modx->mail->send();
$modx->mail->reset();





?>
