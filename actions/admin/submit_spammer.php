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

$izapspamdata = new IzapSpamLogger();

$spammer = get_entity(get_input('guid'));
if (!elgg_instanceof($spammer, 'user')) {
  forward('admin/dashboard');
  exit;
}

$success = True;
$entities = elgg_get_entities(array(
    'types' => array('object', 'group'),
    'owner_guid' => $spammer->guid,
    'limit' => 9999
        ));

if ($entities) {
  foreach ($entities as $entity) {
    $spam_data[$entity->guid] = array(
        'title' => $entity->title,
        'content' => $entity->description,
        'ip' => $entity->izap_from_ip,
        'type' => $entity->getSubtype(),
        'username' => $spammer->username,
        'guid' => $spammer->guid,
        'email' => $spammer->email,
    );

    if ($izapspamdata->insert($spam_data[$entity->guid])) {
      
    } else {
      $success = False;
    }
  }

  if ($success === True) {
    $izapspamdata->upload();
  }
}

forward(REFERER);
exit;

