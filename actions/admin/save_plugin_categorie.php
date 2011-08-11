<?php

/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2010. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */
/*
 * saves the categories for the specific plugin
 */

//get the plugin
$pluign = get_input('plugin');
//gets the categories chosen for the $plugin
$categories = $_POST['categories'];
$plugin = get_entity($pluign);
//if entity is plugin,only then saves the categories with plugin in pluginsetting
if (elgg_instanceof($plugin, 'object', 'plugin')) {
  if (IzapBase::pluginSetting(array(
              'plugin' => $plugin->title,
              'name' => 'izap_categories',
              'value' => $categories,
              'override' => TRUE,
          ))) {
    system_message(elgg_echo('izap-elgg-bridge:categories_saved'));
  } else {
    register_error(elgg_echo('izap-elgg-bridge:categories_not_saved'));
  }
} else {
  register_error(elgg_echo('izap-elgg-bridge:plugin_not_find'));
}

$izap_categories = new IzapCategoryController();
$data = $izap_categories->actionIzap_categories_chooser();
$return['updated_categories'] = $data['plugin_categories'];
echo json_encode($return);
forward(REFERER);