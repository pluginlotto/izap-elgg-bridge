<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version {version} $Revision: {revision}
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
*/
?>
<p>
  <label>
    <?php echo elgg_echo('izap-elgg-bridge:plugin_data_access');?>
    <br />
    <?php echo elgg_view('input/pulldown', array(
      'internalname' => 'params[izap_is_admin_only]',
      'value' => $vars['entity']->izap_is_admin_only,
      'options_values' => array(
        'no' => elgg_echo('izap-elgg-bridge:no'),
        'yes' => elgg_echo('izap-elgg-bridge:yes'),
      ),
    ));?>
  </label>
</p>