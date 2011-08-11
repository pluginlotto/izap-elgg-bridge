<?php

/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */
if(IzapBase::hasFormError()){
  register_error (elgg_echo('izap:elgg:bridge:form_empty'));
forward(REFERER);
}
// gets the posted data for the category through izapbase class
$posted_data = IzapBase::getPostedAttributes();

//initialises new category object
$izap_category = new IzapCategory($posted_data['guid']);
//sets the attributes with the posted values
$izap_category->setAttributes();
//setting the default access
$izap_category->access_id = ACCESS_PUBLIC;
//save the category
if($izap_category->save(TRUE, array('river' => FALSE))) {
  system_message(elgg_echo('izap-elgg-bridge:saved'));
  elgg_clear_sticky_form($posted_data['plugin']);
}
forward(REFERER);