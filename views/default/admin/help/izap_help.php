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

$plugin_id = get_input('plugin');
$readme_content = file_get_contents(elgg_get_plugins_path() . $plugin_id . DIRECTORY_SEPARATOR . 'readme.txt');
$plugin = elgg_get_plugin_from_id($plugin_id);
?>

<div class="izap_readme">
  <?php echo elgg_view_title($plugin->getManifest()->getName());?>
  <br />

  <div class="text">
  <?php echo $readme_content;?>
  </div>
</div>