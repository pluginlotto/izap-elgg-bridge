<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class IzapPluginSettings{
  public function unsetAllSettings(&$plugin) {
    $db_prefix = get_config('dbprefix');

    $q = "DELETE FROM {$db_prefix}private_settings
			WHERE entity_guid = $plugin->guid
			AND name NOT LIKE 'elgg:internal%'";
    return delete_data($q);
  }

}