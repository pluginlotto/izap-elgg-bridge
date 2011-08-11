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

$values = IzapBase::getFormValues(array('plugin' => 'izap-elgg-bridge_categories', 'entity' =>  $vars['entity']));

$form = IzapBAse::input('text', array(
    'input_title' => elgg_echo('izap-elgg-bridge:category_title'),
    'internalname' => 'attributes[_title]',
    'value' => $values->title,
));

$form .= IzapBAse::input('plaintext', array(
    'input_title' => elgg_echo('izap-elgg-bridge:category_description'),
    'internalname' => 'attributes[description]',
    'value' => $values->description,
));

$form .= elgg_view('input/hidden', array('internalname' => 'attributes[plugin]', 'value' => 'izap-elgg-bridge_categories'));
$form .= elgg_view('input/hidden', array('internalname' => 'attributes[guid]', 'value' => $values->guid));
$form .= elgg_view('input/submit', array('value' => elgg_echo('izap-elgg-bridge:save')));
$form .= elgg_view('input/button', array('value' => elgg_echo('izap-elgg-bridge:close'), 'js' => 'onclick="javascript: $(\'#category_main_form\').remove();"', 'class' => 'elgg-button elgg-button-submit'));
$form = elgg_view('input/form', array(
    'body' => $form,
    'action' => IzapBase::getFormAction('add_edit_category', GLOBAL_IZAP_ELGG_BRIDGE),
));
?>
<div id="category_main_form">
  <?php echo $form;?>
</div>