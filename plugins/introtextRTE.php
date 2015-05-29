<?php
// Add RTE for introtext if richtext option is enabled for the resource
// check "OnDocFormRender" event
if($resource && $resource->get('template') == 14){
    $modx->regClientStartupHTMLBlock('<script>Ext.onReady(function() {
    if(MODx.loadRTE) MODx.loadRTE("modx-resource-introtext");
    });</script>');
}
