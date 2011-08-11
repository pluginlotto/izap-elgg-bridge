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

$triggered = trigger_plugin_hook('change:izap_data_center', 'all', NULL, FALSE);
if(!$triggered) {
  define('IZAP_DATA_CENTER', 'ElggGetData');
}

final class ElggGetData {

  public static function get_entities($options) {
    $entities = elgg_get_entities($options);
    // if only counting
    if($options['count']) {
      return (int) $entities;
    }
    if($entities) {
      foreach($entities as $entity) {
        $return[$entity->guid] = self::createEntity($entity);
      }

      unset ($main_attributes, $metadata, $extra_values, $entities, $entity);
      return $return;
    }else {
      return FALSE;
    }
  }

  public static function get_entity($options) {
    $entity = get_entity($options['guid']);
    $return = self::createEntity($entity);
    unset ($entity);
    return $return;
  }

  public static function get_entities_from_metadata($options) {
    $entities = elgg_get_entities_from_metadata($options);
    // if only counting
    if($options['count']) {
      return (int) $entities;
    }

    if($entities) {
      foreach($entities as $entity) {
        $return[$entity->guid] = self::createEntity($entity);
      }

      unset ($entities, $entity);
      return $return;
    }else {
      return FALSE;
    }
  }

  public static function createEntity(ElggEntity $entity) {
    $main_attributes = self::getMainAttributes($entity);
    $metadata = self::getMetadata($entity->guid);
    $extra_values = self::getExtraValues($entity);

    $return = array_merge($extra_values, $main_attributes, $metadata);
    unset ($main_attributes, $metadata, $extra_values);
    return $return;
  }

  public static function getMainAttributes(ElggEntity $entity) {
    if(!$entity) {
      return FALSE;
    }
    $main_attrb = $entity->getExportableValues();
    foreach($main_attrb as $attributes) {
      $return[$attributes] = $entity->$attributes;
    }

    return $return;
  }

  public static function getMetadata($entity_guid) {
    $return = array();
    $metadata = get_metadata_for_entity($entity_guid);
    if($metadata) {
      foreach($metadata as $data) {
        if(!isset ($return[$data->name])) {
          $return[$data->name] = $data->value;
          $return[$data->name . '_access_id'] = $data->access_id;
        }else {
          $return[$data->name] = array_merge((array) $return[$data->name], (array)$data->value);
        }
      }
    }

    return $return;
  }


  public static function getRelationships($entity_guid) {
    $return = array();
    $relation = get_entity_relationships($entity_guid);
    if($relation) {
      foreach($relation as $data) {
        $return[$data->id]['relationship'] = $data->relationship;
        $return[$data->id]['guid_one'] = $data->guid_one;
        $return[$data->id]['guid_two'] = $data->guid_two;
      }
    }

    return $return;
  }

  public static function getExtraValues(ElggEntity $entity) {
    global $CONFIG;
    if(!$entity) {
      return FALSE;
    }
    $return['url'] = $entity->getURL();
    $return['subtype'] = $entity->getSubtype();
    $return['title'] = $entity->title;
    $return['icon_small'] = $entity->getIcon('small');
    $return['icon_medium'] = $entity->getIcon('medium');
    $return['icon_large'] = $entity->getIcon('large');
    $return['access_id'] = $entity->access_id;
    $return['site_url'] = $CONFIG->wwwroot;

    if($entity->canEdit())
      $return['canedit'] = $entity->canEdit();

    if((string) $entity->container_name == '') {
      $container_entity = get_entity($entity->container_guid);
      if($container_entity) {
        $return['container_name'] = $container_entity->name;
        $return['container_username'] = $container_entity->username;
        $return['container_url'] = $container_entity->getURL();
        $return['container_icon'] = str_replace('size=medium', 'size=small', $container_entity->getIcon());
      }
    }else {
      $return['container_name'] = $entity->name;
      $return['container_username'] = $entity->username;
      $return['container_url'] = $entity->getURL();
      $return['container_icon'] = str_replace('size=medium', 'size=small', $entity->getIcon());
    }

    return $return;
  }

}

class IzapGetData {

  public static function getEntities($options) {
    return izap_call_data_function('get_entities', $options);
  }

  public static function getEntity($options) {
    return izap_call_data_function('get_entity', $options);
  }

  public static function getEntitiesFromMetadata($options) {
    return izap_call_data_function('get_entities_from_metadata', $options);
  }

  public static function getEntityMetadata($entity_guid) {
    return izap_call_data_function('getMetadata', $entity_guid);
  }

  public static function getEntityRelationships($entity_guid) {
    return izap_call_data_function('getRelationships', $entity_guid);
  }
}

function izap_call_data_function($method, $options) {
  return call_user_func(array(IZAP_DATA_CENTER, $method), $options);
}