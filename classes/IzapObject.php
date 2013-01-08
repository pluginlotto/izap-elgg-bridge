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


/**
 * Base object class for all the iZAP applications
 */
class IzapObject extends ElggFile {

  protected $_post;
  protected $_guid;
  protected $_attributes;
  protected $_errors = array();

  public $error_code;

  const ERROR_CAN_EDIT='izap_elgg_bridge:error_edit_permission';


  /**
   Initialise the attributes array to include the type,subtype
	 * title, and description.
	 *
	 * @return void
   */
  protected function initializeAttributes() {
    parent::initializeAttributes();
    $this->attributes['subtype'] = get_class($this);
  }


  /**
   * loads or create new IzapObject
   * @global <type> $CONFIG
   * @param  $guid
   */
  public function __construct($guid=null) {
    global $CONFIG;
    parent::__construct($guid);
    $this->_post = $CONFIG->post_byizap;
    if(is_numeric($guid) && $guid > 0 ) {
      $this->_guid = $guid;
    }else {
      $this->_guid = $this->_post->attributes['guid'];
    }
 }


  /**
   * sets the posted values of the form attributes to the entity metadata
   */
  public function setAttributes() {
    foreach($this->getAttributesArray() as $attribute => $config) {
      if(isset ($this->_post->attributes[$attribute])) {
        $this->{$attribute} = $this->_post->attributes [$attribute];
      }
    }
  }


  /**
   * find if the object has the error
   * @return boolean
   */
  public function validate() {
    return !$this->hasError();
  }


  /**
   *  save the entity and updates the metadata
   * adds  the entity to the river
   * @global  $CONFIG
   * @param boolean $validate
   * @param array $options more information useful to save the entity
   * @return boolean
   */
  public function save($validate = true, $options = array()) {
    global $CONFIG;

    if($this->_guid && !$this->canEdit()) {
      $this->error_code=self::ERROR_CAN_EDIT;
      return false;
    }

    if($validate) {
      $validated = $this->_post->form_validated && $this->validate();
    } else {
      $validated = true;
    }
    $river_action = $this->isNewRecord() ? 'created' : 'updated';
    if ($validated && parent::save()) {
      if($options['river'] !== false) {        
        $view = "river/{$this->getType()}/{$this->getSubtype()}/{$river_action}";
        if(!elgg_view_exists($view)) {
          $view = "river/{$this->getType()}/{$this->getSubtype()}/default";
          if(!elgg_view_exists($view)) {
            $view = "river/{$this->getType()}/default";
          }
        }
        add_to_river(
                $view,
                $river_action,
                elgg_get_loggedin_userid(),
                $this->guid
        );
      }

      // save some more info, so that we can use them for easy processing
      $this->slug = elgg_get_friendly_title($this->title);
      $this->owner_username = IzapBase::getOwnerUsername($this);
      $this->owner_name = IzapBase::getOwnerName($this);
      $this->container_username = IzapBase::getContainerUsername($this);
      $this->container_name = IzapBase::getContainerName($this);
      return true;
    }
    return false;
  }


  /**
   * checks if the object is new or not
   * @return boolean
   */
  public function isNewRecord() {
    return ($this->guid)?false:true;
  }


  /**
   * saves the message for the error
   * @param mixed $attribute
   * @param string $msg
   */
  public function addError($attribute, $msg) {
    $this->_errors[$attribute][] = $msg;
  }


  /**
   * checks if the object has error
   * @return boolean
   */
  public function hasError() {
    return sizeof($this->_errors) ? true : false;
  }


  /**
   * returns the errors
   * @return string
   */
  public function getErrors() {
    return $this->_errors;
  }

  // some html output functions


  /**
   * returns the title in the minified or full size
   * @param array $vars
   *                max_length => maximum length of the title to display
   *                mini => true to display the minified form
   * @return string
   */
  public function getTitle($vars = array()) {
    $array_value['value'] = $this->title;
    $title = elgg_view('output/text', array_merge((array) $vars, (array) $array_value));

    $orignal_length = strlen($title);

    if(((int)$vars['max_length'] > 0) && ((int)$vars['max_length'] < $orignal_length) && $vars['mini']) {
      $title = substr(strip_tags($title), 0, (int)$vars['max_length']);
      $title .= ' ...';
    }

    return $title;
  }


  /**
   * displays the description in minified/full length
   * @param array $vars
   *                max_length => maximum length of the title to display
   *                mini => true to display the minified form
   * @return string
   */
  public function getDescription($vars = array()) {
    $array_value['value'] = $this->description;
    $description = elgg_view('output/longtext', array_merge((array) $vars, (array) $array_value));
    $orignal_length = strlen($description);

    if(((int)$vars['max_length'] > 0) && ((int)$vars['max_length'] < $orignal_length) && $vars['mini']) {
      $description = substr(strip_tags($description), 0, (int)$vars['max_length']);
      $description .= ' ...';
    }

    return $description;
  }


  /**
   * returns the link of the object
   * @param array $vars vars
   * @return elgg view
   */
  public function getLink($vars = array()) {
    $array_value['value'] = $this->getURL();
    return elgg_view('output/url', array_merge((array) $vars, (array) $array_value));
  }


  /**
   * returns the ownerusername
   * @return string
   */
  public function getOwnerUsername() {
    return IzapBase::getOwnerUsername($this);
  }

  /**
	 * Can a user comment on entity?
	 *
	 * @see ElggObject::canComment()
	 *
	 * @param int $user_guid User guid (default is logged in user)
	 * @return bool
	 */
	public function canComment($user_guid = 0) {
		$result = parent::canComment($user_guid);
		if ($result == false) {
			return $result;
		}
		if (!$this->comments_on) {
			return false;
		}
		return true;
	}
}