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

class IzapCategory extends IzapObject {

  public function __construct($guid = null) {
    parent::__construct($guid);
  }

  protected function initialise_attributes() {
    parent::initializeAttributes();
  }

  public function getAttributesArray() {
    return array(
        'title' => array(),
        'description' => array()
    );
  }

  public function delete() {
    return delete_entity($this->guid);
  }
}