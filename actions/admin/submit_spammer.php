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

$izapspamdata = new IzapSpamLogger();

$spammer = get_entity(get_input('guid'));
if(!elgg_instanceof($spammer, 'user')) {
  forward('admin/dashboard');
  exit;
}

$success = TRUE;
$entities = elgg_get_entities(array(
        'types' => array('object', 'group'),
        'owner_guid' => $spammer->guid,
        'limit' => 9999
));

if($entities) {
  foreach($entities as $entity) {
    $spam_data[$entity->guid] = array(
            'title' => $entity->title,
            'content' => $entity->description,
            'ip' => $entity->izap_from_ip,
            'type' => $entity->getSubtype(),
            'username' => $spammer->username,
            'guid' => $spammer->guid,
            'email' => $spammer->email,
    );

    if($izapspamdata->insert($spam_data[$entity->guid])) {
     // delete_entity($entity->guid);
    }else {
      $success = false;
    }

  }

  if($success === TRUE) {
    $izapspamdata->upload();
//    if($spammer->ban(elgg_echo('izap-antispam:ban_reason'))) {
//      // clear all other data @TODO: Need more discussion on it
//      $spammer->deleteAnnotations();
//      $spammer->deleteOwnedAnnotations();
//      $spammer->deleteRelationships();
//      remove_from_river_by_subject($spammer->guid);
//      remove_from_river_by_object($spammer->guid);
//
//      // reset for the counts in case the user in unbanned next time
//      $spammer->izap_is_spammer = 'no';
//      $spammer->izap_spammer_hotness = 0;
//      $spammer->izap_avg_post_time = 0;
//      $spammer->izap_avg_check_time = 0;
//      $spammer->izap_consicutive_try = 0;
//      $spammer->izap_last_posted = 0;
//
//      system_message(elgg_echo('izap-antispam:user_banned'));
//    }
  }
}

forward(REFERER);
exit;

