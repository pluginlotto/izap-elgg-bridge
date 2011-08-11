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


/*
 * marks the entity as non-spammer and make it hotness zero
 */
$user = get_entity(get_input('guid'));
 if(elgg_instanceof($user, 'user')) {
   $user->izap_is_spammer = 'no';
   $user->izap_spammer_hotness = 0;
 }
 forward(REFERER);