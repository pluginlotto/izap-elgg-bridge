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

class IzapCategoriesController extends IzapController {

  public function __construct($page) {
    parent::__construct($page);
    $this->addWidget(GLOBAL_IZAP_ELGG_BRIDGE . '/categories');
  }
/**
 * 
 */
  public function actionList() {
    
    echo $category = get_entity($this->url_vars[1]);
    $entities = elgg_list_entities_from_metadata(array(
                'type' => 'object',
                'subtype' => $this->url_vars[2],
                'metadata_name' => 'categories',
                'metadata_value' => $category->guid,
                'full_view' => FALSE
            ));
    $this->page_elements['title'] = elgg_echo('izap-bridge:categories:search_result', array($category->title));
    $this->page_elements['content'] = elgg_view(GLOBAL_IZAP_ELGG_BRIDGE . '/category_filter', array('category' => $this->url_vars[1],'selected'=>$this->url_vars[2]));
    $this->page_elements['filter'] = '';
    if(!empty($entities)){
    $this->page_elements['content'] .= '<div id="searched_items">' . $entities. '</div>';}
    else
      $this->page_elements['content'] .= '<div id="searched_items">'. elgg_echo('izap:bridge:category:no_data').'</div>';
    $this->drawPage();
  }


  public function actionAjax_list() {
    $category = get_entity($this->url_vars[1]);
    $entities = elgg_list_entities_from_metadata(array(
                'type' => 'object',
                'subtype' => $this->url_vars[2],
                'metadata_name' => 'categories',
                'metadata_value' => $category->guid,
                'full_view' => FALSE
            ));
if(!empty($entities)){
    echo $entities;}

else
  echo elgg_echo('izap:bridge:category:no_data');
    
  }

}