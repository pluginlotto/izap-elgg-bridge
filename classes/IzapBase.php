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

/**
 * methods of this class will be called statically only
 */
class IzapBase {

  /**
   * used to set all the href
   *
   * @global <type> $CONFIG
   * @param array $input array of all the params like
   *              'context' => 'videos',
   *
   * @return string
   */
  public static function setHref($input = array()) {
    global $CONFIG;

    /**
     * Default Params
     */
    $default = array(
        'trailing_slash' => TRUE,
        'full_url' => TRUE,
    );
    $params = array_merge($default, $input);

    // start url array
    $url_array = array();
    //$url_array[] = 'pg';

    if ($params['context']) {
      $url_array[] = $params['context'];
    } else {
      $url_array[] = elgg_get_context();
    }

    // set which page to call
    $url_array[] = $params['action'];

    // check to set the page owner
    if ($params['page_owner'] !== FALSE) {
      if (isset($params['page_owner'])) {
        $url_array[] = $params['page_owner'];
      } elseif (elgg_get_page_owner_entity ()) {
        $url_array[] = elgg_get_page_owner_entity()->username;
      } elseif (elgg_is_logged_in ()) {
        $url_array[] = elgg_get_logged_in_user_entity()->username;
      }
    }

    if (is_array($params['vars']) && sizeof($params['vars'])) {
      foreach ($params['vars'] as $var) {
        $url_array[] = filter_var($var);
      }
    }

    // short circuit for empty values
    foreach ($url_array as $value) {
      if (!empty($value)) {
        $final_array[] = $value;
      }
    }

    // create URL
    $final_url = implode('/', $final_array);

    if ($params['full_url']) {
      $final_url = $CONFIG->wwwroot . $final_url;
    }
    // check for trailing_slash
    if ($params['trailing_slash']) {
      $final_url .= '/';
    }

    return $final_url;
  }

  /**
   * allows the action to available only to logged in/admin
   * 
   * @param string $access_to logged_in or admin
   */
  public static function gatekeeper($access_to = 'logged_in') {
    if (empty($access_to)) { // in case sent value is empty
      $access_to = 'logged_in';
    }

    if ($access_to == 'logged_in') {
      gatekeeper();
    } elseif ($access_to == 'admin') {
      admin_gatekeeper();
    }
  }

  /**
   * calls the input view with <p> and <label> tag included
   * 
   * @param string $input input view name
   * @param array $vars vars
   * @return string complete view
   * 
   */
  public static function input($input, $vars = array()) {
    $return = '<p><label>';
    $return .= $vars['input_title'] . '<br />';
    unset($vars['input_title']);
    $return .= elgg_view('input/' . $input, $vars);
    $return .= '</label></p>';

    return $return;
  }

  /**
   * sends back the full path of the action
   * @global  $CONFIG
   * @param string $file name of the action file
   * @param string $plugin plugin name
   * @return string the full path of the action
   */
  public static function getFormAction($file, $plugin) {
    global $CONFIG;

    return $CONFIG->wwwroot . 'action/' . $plugin . '/' . $file;
  }

  /**
   * loads the library for the plugin
   * @param array $vars array containing the plugin and library names
   */
  public static function loadLib($vars) {
    elgg_load_library('izap:' . $vars['plugin'] . ':' . $vars['lib']);
  }

  /**
   * sets the settings for the plugin
   * 
   * @param array $supplied_array info for the setting to be saved
   * @return mix array or string the setting's value
   */
  public static function pluginSetting($supplied_array) {
    $default = array(
        'override' => FALSE,
        'make_array' => FALSE,
    );

    $input = array_merge($default, (array) $supplied_array);
    // get old values
    $old_value = elgg_get_plugin_setting($input['name'], $input['plugin']);

    //make new value
    if (is_array($input['value'])) {
      $new_value = implode('|', $input['value']);
    } else {
      $new_value = $input['value'];
    }

    if ((!(bool) $old_value && !empty($new_value)) || $input['override']) {
      if (!elgg_set_plugin_setting($input['name'], $new_value, $input['plugin'])) {
        return FALSE;
      } else {
        $return = $new_value;
      }
    }

    if ((bool) $old_value !== FALSE) {
      $old_array = explode('|', $old_value);
      if (count($old_array) > 1) {
        $return = $old_array;
      } else {
        $return = $old_value;
      }
    }

    if (!is_array($return) && $input['make_array'] && (bool)$return) {
      $new_return_val[] = $return;
      $return = $new_return_val;
    }

    return $return;
  }

  /**
   * checks if the form has any error
   * @global $CONFIG
   * @return boolean true if error else false
   */


  public static function byteToMb($size){
    return round(((float)$size)/(1024*1024),2);

  }

 public static function mb2byte($mb) {
  return 1024*1024*$mb;
}


  public static function hasFormError() {
    global $CONFIG;
    return!$CONFIG->post_byizap->form_validated;
  }


  /**
   * returns the posted values of the form
   * @global  $CONFIG
   * @param  $attrib form attribute
   * @return mix all the posted values or the particular attribute value
   */
  public static function getPostedAttributes($attrib = FALSE) {
    global $CONFIG;
    if ($attrib) {
      return $CONFIG->post_byizap->attributes[$attrib];
    }
    return $CONFIG->post_byizap->attributes;
  }


  /**
   * returns the form errors
   * @global  $CONFIG
   * @param boolean $to_string
   * @return mix the array or string of errors
   */
  public static function getFormErrors($to_string = FALSE) {
    global $CONFIG;
    if ($to_string) {
      return implode('<br />', $CONFIG->post_byizap->form_errors);
    }

    return $CONFIG->post_byizap->form_errors;
  }


  /**
   * updates the form posted attributes
   * 
   * @global  $CONFIG
   * @param string $attribute
   * @param mixed $value
   */
  public static function updatePostedAttribute($attribute, $value) {
    global $CONFIG;
    $CONFIG->post_byizap->attributes[$attribute] = $value;
  }


  /**
   * sends the mail
   * @global  $CONFIG
   * @param <type> $params
   *                    'from' => valid from email address
   *                    'from_username' => from username
   *                    'to' => valid to email address
   *                    'subject' => the subject of the mail
   *                    'msg' => the actual message
   * @return boolen true if mail sent successfully else false
   */
  public static function sendMail($params) {
    global $CONFIG;

    if (!is_array($params)) {
      return FALSE;
    }

    $header_eol = "\r\n";
    if (
            (isset($CONFIG->broken_mta)) &&
            ($CONFIG->broken_mta)
    ) {
      // Allow non-RFC 2822 mail headers to support some broken MTAs
      $header_eol = "\n";
    }

    $from_email = $params['from_username'] . " <" . $params['from'] . ">";
    if (strtolower(substr(PHP_OS, 0, 3)) == 'win') {
      // Windows is somewhat broken, so we use a different format from header
      $from_email = $params['from'];
    }

    $headers = "From: " . $from_email . "{$header_eol}"
            . "Content-Type: text/html; charset=UTF-8; format=flowed{$header_eol}"
            . "MIME-Version: 1.0{$header_eol}"
            . "Content-Transfer-Encoding: 8bit{$header_eol}";

    return mail($params['to'], $params['subject'], $params['msg'], $headers);
  }


  /**
   * gives the full entity from the name
   * @param string $username
   * @return entity entity if it is valid else false
   */
  public static function getEntityFromUsername($username) {
    if (substr_count($username, 'group:')) {
      preg_match('/group\:([0-9]+)/i', $username, $matches);
      $guid = $matches[1];
      $entity = get_entity($guid);
      if ($entity) {
        set_input('izap_current_user', 'group');
        return $entity;
      }
    }

    $user = get_user_by_username($username);
    if ($user) {
      set_input('izap_current_user', 'user');
      return $user;
    }

    return FALSE;
  }


  /**
   * sets the pageowner
   * @param mixed $username user/group username or guid
   * @TODO make it better
   */
  public static function setPageOwner($username) {
    if (is_numeric($username)) {
      elgg_set_page_owner_guid($username);
    } elseif (is_string($username)) {
      $entity = self::getEntityFromUsername($username);
      if ($entity) {
        if (get_input('izap_current_user') == 'user') {
          set_input('izap_current_page_owner', 'user');
        } elseif (get_input('izap_current_user') == 'group') {
          set_input('izap_current_page_owner', 'group');
        }
        elgg_set_page_owner_guid($entity->guid);
      }
    } elseif (elgg_is_logged_in ()) {
      set_input('izap_current_page_owner', 'user');
      elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
    }
  }


  /**
   * gives the api key's value for the bridge
   * @return string
   */
  public static function APIKEY() {
    return self::pluginSetting(array(
        'name' => 'izap_api_key',
        'plugin' => GLOBAL_IZAP_ELGG_BRIDGE
    ));
  }


  /**
   * sends caching headers
   * @param array $options
   *
   */
  public static function cacheHeaders($options = array()) {
    $sessions_start_time = (int) $_SESSION['start_time'];
    if (!$sessions_start_time) {
      $_SESSION['start_time'] = time();
    }
    $defaults = array(
        'expire_time' => 864000, // Ten days
        'content_type' => 'text/html',
        'file_name' => current_page_url(),
        'filemtime' => $sessions_start_time,
    );

    $working = array_merge($defaults, $options);
    extract($working);
    
    header("Pragma: public", true);
    header("Cache-Control: maxage=" . $expire_time . " public", true);
    header('Expires: ' . date('r', time() + $expire_time), true);
    header("Last-Modified: " . date('r', $filemtime));
    header("Content-type: {$content_type}", true);
    header("Content-Disposition: inline; filename=\"{$file_name}\"", true);
  }


  /**
   * gives the file's extension if file found
   * @param string $filename
   * @return mixed file extension if found else false
   */
  public static function getFileExtension($filename) {
    if (empty($filename)) {
      return false;
    }

    return strtolower(end(explode('.', $filename)));
  }


  /**
   * loads the form with the pre-filled values from the sticky form or entity 
   * supplied
   *
   * @param array $params
   *                  'entity' => entity for filling the values in edit case
   *                  'plugin' => pluign id to get the sticky form values
   *
   * @return stdClass object values
   */
  public static function getFormValues($params) {
    // params must be array
    if (!is_array($params)) {
      return FALSE;
    }

    $return_value = $params['entity'];
    if (elgg_is_sticky_form($params['plugin'])) {
      $attribs = $_SESSION['sticky_forms'][$params['plugin']]['attributes'];
      foreach ($attribs as $key => $val) {
        if ($key[0] == "_") {
          $attr = substr($key, 1);
        } else {
          $attr = $key;
        }
        $return_value->$attr = filter_tags($_SESSION['sticky_forms'][$params['plugin']]['attributes'][$key]);
      }
    }

    elgg_clear_sticky_form($params['plugin']);
    return $return_value;
  }


  /**
   * prints the pluginlotto 's link
   */
  public static function echoIzapLink() {
    echo elgg_view(GLOBAL_IZAP_ELGG_BRIDGE . '/our_link');
  }


  /**
   * checks if the user can add a friend
   * @param ElggUser $user
   * @return boolean
   */
  public static function canAddFriend(ElggUser $user) {
    if (!isloggedin())
      return FALSE;

    if ($user->getGUID() == get_loggedin_user()->getGuid())
      return FALSE;

    if ($user->isFriendOf(get_loggedin_user()->getGuid()))
      return FALSE;

    return TRUE;
  }

  /**
   * generates complete uniquie id
   *
   * @param string|int $input any input so that it can merged into hash creation
   * @return string
   */
  public static function getUniqueId($input = '') {
    $microtime = md5(microtime(TRUE));
    $rand = rand(rand(43, 1985), time());
    $input = md5($input);

    return md5($microtime . $rand . $input . rand(43, 1985));
  }


  /**
   * overrides all access
   * @param string $func_name
   * @param <type> $priority
   */
  public static function getAllAccess($func_name = 'izap_access_over_ride', $priority = 99999) {
    elgg_register_event_handler("enable", "all", $func_name, $priority);
    elgg_register_plugin_hook_handler("permissions_check", "all", $func_name, $priority);
    elgg_register_plugin_hook_handler("container_permissions_check", "all", $func_name, $priority);
    elgg_register_plugin_hook_handler("permissions_check:metadata", "all", $func_name, $priority);
  }


  /**
   *rollback all the access
   * @param string $func_name
   */
  public static function removeAccess($func_name = 'izap_access_over_ride') {
    elgg_unregister_event_handler("enable", "all", $func_name);
    elgg_unregister_plugin_hook_handler("permissions_check", "all", $func_name);
    elgg_unregister_plugin_hook_handler("container_permissions_check", "all", $func_name);
    elgg_unregister_plugin_hook_handler("permissions_check:metadata", "all", $func_name);
  }


  /**
   * updates the metadata
   * @param array $provided
   *                entity => entity to be updated
   *                guid => entitiy's guid
   * @return boolean true if updates successfull else false
   */
  public static function updateMetadata($provided) {

    $default = array(
        'force' => TRUE,
    );

    $working_array = array_merge($default, $provided);

    // try creating new entity
    if (!$working_array['entity']) {
      if ($working_array['guid']) {
        $working_array['entity'] = get_entity($working_array['guid']);
      }
    }

    // CHECK IF THERE IS ENTITY TO UPDATE
    if (!$working_array['entity']) {
      return FALSE;
    }

    // if forced, add access
    if ($working_array['force']) {
      self::getAllAccess();
    }
    // only work if there is some value
    if (is_array($working_array['metadata']) && sizeof($working_array['metadata'])) {
      foreach ($working_array['metadata'] as $metadata_name => $metadata_values) {
        $working_array['entity']->$metadata_name = $metadata_values;
      }
    } else {
      // no metadata isset
      return FALSE;
    }

    // if forced, now remove access
    if ($working_array['force']) {
      self::removeAccess();
    }

    return TRUE;
  }

  /**
   * creates common delete link for all entities
   * @param array $array
   * @return mixed
   */
  public static function deleteLink($array) {
    // must be array
    if (!is_array($array)) {
      return FALSE;
    }

    $default = array(
        'only_url' => FALSE,
        'text' => elgg_echo('izap-bridge:delete'),
        'confirm' => elgg_echo('izap-bridge:are_you_sure'),
        'rurl' => FALSE,
    );

    $working_array = array_merge($default, $array);

    // genetrate action url
    $query_params['guid'] = $working_array['guid'];
    if ($working_array['rurl'])
      $query_params['rurl'] = $working_array['rurl'];

    $working_array['href'] = self::getFormAction('delete', GLOBAL_IZAP_ELGG_BRIDGE) . '?' . http_build_query($query_params);

    // return url only if requested
    if ($working_array['only_url'] === TRUE) {
      return elgg_add_action_tokens_to_url($working_array['href']);
    }

    unset($working_array['make_link']);
    return elgg_view('output/confirmlink', $working_array);
  }


  /**
   * check if request is ajax request
   * @return boolean
   */
  public static function isAjaxRequest() {
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
  }


  /**
   * gives the time with proper formatting
   * @param integer $sec
   * @return string
   */
  public static function formattedTime($sec) {
    if ($sec >= 60) {
      $min = $sec / 60;
      $sec = $sec % 60;
    }
    else
      return (int) $sec . ' secs';

    if ($min >= 60) {
      $hr = $min / 60;
      $min = $min % 60;
    }
    else
      return (int) $min . ' mins ' . (int) $sec . ' secs';

    if ($hr >= 24) {
      $days = $hr / 24;
      $hr = $days % 24;
      return (int) $days . ' days ';
    }
    else
      return (int) $hr . ' hrs ' . (int) $min . ' mins ' . (int) $sec . ' secs';
  }


  /**
   * Increment the views when user visits the page
   * @param elggEntity $entity
   */
  public static function increaseViews($entity) {
    if (is_object($entity)) {
      self::getAllAccess();
      $entity->total_views++;
      self::removeAccess();
    }
  }


  /**
   * Decrement the views
   * @param elggEntity $entity
   */
  public static function decreaseViews($entity) {
    if (is_object($entity)) {
      self::getAllAccess();
      $entity->total_views--;
      self::removeAccess();
    }
  }


  /**
   * gives the total number of views of the entity
   * @param elggEntity $entity
   * @return string
   */
  public static function getViews($entity) {
    return (int) $entity->total_views;
  }


  /**
   * saves the image file
   * @param array $file_array
   *                      destination => path where to save the file
   *                      content => content of image
   *                      owner_id => owner id of the image file
   *
   * @return boolean
   */
  public static function saveImageFile($file_array) {
    if (!is_array($file_array)) {
      return FALSE;
    }

    $destination = $file_array['destination'];
    $content = $file_array['content'];

    $filehandler = new ElggFile();
    $filehandler->owner_guid = ($file_array['owner_guid'] ? $file_array['owner_guid'] : elgg_get_logged_in_user_guid());
    $filehandler->setFilename($destination . '.jpg');
    $filehandler->open("write");
    $return = $filehandler->write($content);
    $filehandler->close();

    if ($file_array['create_thumbs'] && $return) {
      $thumbtopbar = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 16,16,true);
      $thumbtiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 25, 25, true);
      $thumbsmall = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 40, 40, true);
      $thumbmedium = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 100, 100, true);
      $thumblarge = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 200, 200, false);
      if ($thumbtiny) {

        $thumb = new ElggFile();
        $thumb->owner_guid = ($file_array['owner_guid'] ? $file_array['owner_guid'] : elgg_get_logged_in_user_guid());
        $thumb->setMimeType('image/jpeg');

        $thumb->setFilename($destination . 'topbar.jpg');
        $thumb->open("write");
        $thumb->write($thumbtopbar);
        $thumb->close();

        $thumb->setFilename($destination . 'tiny.jpg');
        $thumb->open("write");
        $thumb->write($thumbtiny);
        $thumb->close();

        $thumb->setFilename($destination . 'small.jpg');
        $thumb->open("write");
        $thumb->write($thumbsmall);
        $thumb->close();

        $thumb->setFilename($destination . 'medium.jpg');
        $thumb->open("write");
        $thumb->write($thumbmedium);
        $thumb->close();

        $thumb->setFilename($destination . 'large.jpg');
        $thumb->open("write");
        $thumb->write($thumblarge);
        $thumb->close();
      }
    }

    return $return;
  }


  /**
   * get the file
   * @param array $file_array
   *                    'source' => file source
   * @return  mixed The file contents.
   */
  public static function getFile($file_array) {
    if (!is_array($file_array)) {
      return FALSE;
    }

    $source = $file_array['source'];

    $filehandler = new ElggFile();
    $filehandler->owner_guid = ($file_array['owner_guid'] ? $file_array['owner_guid'] : elgg_get_logged_in_user_guid());
    $filehandler->setFilename($source);
    $filehandler->open("read");
    return $filehandler->grabFile();
  }


  /**
   * gives the container's username
   * 
   * @param elggEntity $entity
   * @return string container's username
   */
  public static function getContainerUsername($entity) {
    if ($entity) {
      $c_username = (string) $entity->container_username;
      if (empty($c_username)) {
        $c_username = get_entity($entity->container_guid)->username;
        // try setting the same;
        self::getAllAccess();
        $entity->container_username = $c_username;
        self::removeAccess();
      }
    }

    return (string) $c_username;
  }


  /**
   * gives the container's name
   * @param elggEntity $entity
   * @return string container's name
   */
  public static function getContainerName($entity) {
    if ($entity) {
      $c_name = (string) $entity->container_name;
      if (empty($c_name)) {
        $c_name = get_entity($entity->container_guid)->name;
        // try setting the same;
        self::getAllAccess();
        $entity->container_name = $c_name;
        self::removeAccess();
      }
    }

    return (string) $c_name;
  }


  /**
   * gives the owner's username of the entity
   * @param elggEntity $entity
   * @return string owner username
   */
  public static function getOwnerUsername($entity) {
    if ($entity) {
      $o_username = (string) $entity->owner_username;
      if (empty($o_username)) {
        $o_username = get_entity($entity->owner_guid)->username;
        // try setting the same;
        self::getAllAccess();
        $entity->owner_username = $o_username;
        self::removeAccess();
      }
    }

    return (string) $o_username;
  }


  /**
   * gives the owner's name of the entity
   * @param elggEntity $entity
   * @return string owner's name
   */
  public static function getOwnerName($entity) {
    if ($entity) {
      $o_name = (string) $entity->owner_name;
      if (empty($o_name)) {
        $o_name = get_entity($entity->owner_guid)->name;
        // try setting the same;
        self::getAllAccess();
        $entity->owner_name = $o_name;
        self::removeAccess();
      }
    }

    return (string) $o_name;
  }

 
     /**
   *
   * @param <type> $params Possible values array('entity' => , 'handler' => , 'page_owner' => (true/false))
   */
  public static function controlEntityMenu($params){
    return $metadata = elgg_view_menu('entity', array(
          'entity' => $params['entity'],
          'handler' => $params['handler'],
          'page_owner' => $params['page_owner'] ,
          'sort_by' => 'priority',
          'class' => 'elgg-menu-hz',

        ));
  }

}

/**
 * common function for overriding all the access
 * @param string $hook
 * @param string $entity_type
 * @param <type> $return
 * @param araay $params
 * @return boolean always TRUE
 */
function izap_access_over_ride($hook, $entity_type, $return, $params=array()) {
  return true;
}
