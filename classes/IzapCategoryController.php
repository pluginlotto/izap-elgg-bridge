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

class IzapCategoryController {

  public function actionIzap_categories_chooser() {
    $plugins = elgg_get_plugins();
    $categories = elgg_get_entities(array(
        'limit' => 100,
        'type' => 'object',
        'subtype' => GLOBAL_IZAP_BRIDGE_CATEGORIES_SUBTYPE,
            ));

    foreach ($plugins as $plugin) {
      $return['plugins'][$plugin->guid] = $plugin->getManifest()->getName();
      $return['plugin_categories'][$plugin->guid] = IzapBase::pluginSetting(array(
                  'plugin' => $plugin->title,
                  'name' => 'izap_categories',
                  'make_array' => TRUE,
              ));
    }

    foreach ($categories as $category) {
      $return['categories'][$category->title] = $category->guid;
    }

    return $return;
  }

}