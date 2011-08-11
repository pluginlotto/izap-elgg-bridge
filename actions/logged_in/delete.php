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

$guid = get_input('guid');
$entity = get_entity($guid);
$forward_url = get_input('rurl', '');
if ($forward_url == '') {
  $forward_url = REFERER;
}
if ($entity) {
  //try deleting entity
  try {
    if ($entity->delete())
      system_message(elgg_echo('izap-bridge:delete_success'));
    else
      register_error(elgg_echo('izap-bridge:delete_error'));
  } catch (CallException $e) {
    register_error(vsprintf(elgg_echo('izap-bridge:delete_error'), array($e->getMessage())));
  }
} else {
  register_error(elgg_echo('izap-bridge:invalid_entity'));
}
forward($forward_url);
exit;