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

function izap_registration_sniffer($hook, $type, $returnvalue, $params) {

}

function izap_login_sniffer($event, $object_type, $user) {
  // update all the login count for all user, need for the antispam
  $user->izap_total_logins++;

  return TRUE;
}

function izap_entity_creation_sniffer($event, $object_type, $object) {
  // insert ip with all entity created (object, user & group)
  if(in_array($object_type, array('object', 'group')) || ($object->type == 'annotation' && $object->name == 'generic_comment')) {
    $object->izap_from_ip = $_SERVER['REMOTE_ADDR'];
    
    $cop = new IzapAntiSpam($object);
    return $cop->canPost();
  }

  return TRUE;
}

function izap_entity_updation_sniffer($event, $object_type, $object) {

  return TRUE;
}

function izap_entity_deletion_sniffer($event, $object_type, $object) {

  return TRUE;
}

function izap_htmlawed_hook($hook, $entity_type, $returnvalue, $params) {
  global $CONFIG;
  $url_params = parse_url(elgg_get_site_url());
  $ignore_url = str_replace('.', '\.', $url_params['host']);

  $extra_config = array(
          'anti_link_spam' => array('`://\W*(?!('.$ignore_url.'))`', ''),
  );

  return array_merge((array) $returnvalue, $extra_config);
}

/**
 *
 * Hook to create control menu for all entities for izap-elgg-bridge compatible
 * plugins. (access, edit, like, delete)
 * @param <type> $hook
 * @param <type> $type
 * @param <type> $return
 * @param <type> $params
 * @return <type>
 *
 */
function izap_entity_menu_setup($hook, $type, $return, $params) {

  if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);

	// access
	$access = elgg_view('output/access', array('entity' => $entity));
	$options = array(
		'name' => 'access',
		'text' => $access,
		'href' => false,
		'priority' => 100,
	);
	$return[] = ElggMenuItem::factory($options);

	if ($entity->canEdit() && $handler) {
		// edit link
		$options = array(
			'name' => 'edit',
			'text' => elgg_echo('edit'),
			'title' => elgg_echo('edit:this'),
      'href' => IzapBase::setHref(isset($params['page_owner'])?array('page_owner' => $params['page_owner'],'context' => $handler, 'action' => 'edit', 'vars' => array($entity->getGUID())):array('context' => $handler, 'action' => 'edit', 'vars' => array($entity->getGUID()))),
			'priority' => 200,
		);
		$return[] = ElggMenuItem::factory($options);

		// delete link
		$options = array(
			'name' => 'delete',
			'text' => elgg_view_icon('delete'),
			'title' => elgg_echo('delete:this'),
      'href' => IzapBase::deleteLink(array('guid'=> $entity->getGUID(), 'only_url' => true)),
			'confirm' => elgg_echo('deleteconfirm'),
			'priority' => 300,
		);
		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}