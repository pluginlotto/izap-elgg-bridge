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
 *
 *
 * $vars['plugin_id'] guid of the plugin
 *
 *
 */

$vars['internalname'] = ($vars['internalname']) ? $vars['internalname'] : 'attributes[categories][]';
$categories = IzapBase::pluginSetting(array(
            'plugin' => $vars['plugin_id'],
            'name' => 'izap_categories',
            'make_array' => TRUE,
        ));
if (sizeof($categories)) {
  $categories_entities = elgg_get_entities(array('guids' => $categories));
  if ($categories_entities) {
    foreach ($categories_entities as $category) {
      $options_values[$category->title] = $category->guid;
    }
  }
  $vars['options'] = $options_values;
  echo elgg_view('input/checkboxes', $vars);
}