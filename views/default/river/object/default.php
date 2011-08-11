<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version 1.0
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
*/

$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
$object = get_entity($vars['item']->object_guid);

$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
$contents = strip_tags($object->description); //strip tags from the contents to stop large images etc blowing out the river view

$string = $url . ' has '.$vars['item']->action_type.' '  . elgg_echo('item:' . $object->getType() . ':' . $object->getSubtype() . ':singular') . ' ';
$string .= " <a href=\"" . $object->getURL() . "\">" . $object->title . "</a>";
$string .= "<div class=\"river_content_display\">";
$string .= '<a href="'.$object->getURL().'"><img src="'.$object->getIcon().'" align="left" class="izap_river_icon"/></a>';
if(strlen($contents) > 200) {
  $string .= substr($contents, 0, strpos($contents, ' ', 200)) . "...";
}else {
  $string .= $contents;
}
$string .= "</div><div class=\"clearfloat\"></div>";
echo $string;
