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
 * master class for all izap controller
 */
abstract class IzapController {

  public $controller;
  public $action;
  public $url_vars = array();

  public $page_shell = 'default';
  public $page_layout = 'content';
  public $page_elements = array(
          'sidebar' => '',
          'title' => '',
          'content' => '',
  );
  public $widgets;
  public $buttons;


  /**
   *
   * @param <type> $page 
   */
  public function  __construct($page) {
    // set the controller
    $this->controller = GLOBAL_IZAP_CURRENT_CONTROLLER;
    // lets make action now
    $this->action = 'action' . ucfirst($page[0]);

    // if the actions doesn't exists, then run index
    if(!method_exists($this->controller, $this->action)) {
      $this->action = 'actionIndex';
    }
    
    unset ($page[0]);
    $this->url_vars = $page;
  }

  /**
   * calls the action for the current page
   */
  public function runAction() {
    $this->{$this->action}();
  }

  /**
   * this action creates the blank page in case of the error
   */
  public function actionError() {
    $this->page_elements['filter'] = '';
    // make body
    $body = elgg_view_layout($this->page_layout, $this->page_elements);
    // draw page
    echo elgg_view_page($this->page_elements['title'], $body);
  }

  /**
   * adds the buttons to the specified menu
   * @param array $array
   *                menu_name => menu name of the button
   *                $title => title of button
   *                $url => link of the button
   *
   */
  protected function addButton($array) {
    extract($array);
        
    if(!empty($title) && !empty($menu_name)) {
      elgg_register_menu_item($menu_name, array(
              'name' => elgg_get_friendly_title($title),
              'href' => $url,
              'text' => $title,
              'link_class' => 'elgg-button elgg-button-action',
      ));

    }
  }


  /**
   * adds the widget to 
   * @param <type> $view
   * @param <type> $vars
   * @param <type> $position
   */
  protected function addWidget($view, $vars = array(), $position = 'sidebar') {
    $this->widgets[] = elgg_view($view, $vars);
  }

  public function render($view, $vars = array(), $draw_page = TRUE) {
    // get content from view
    $this->page_elements['content'] = elgg_view($view, $vars);

    // draw page
    if($draw_page)
      $this->drawPage();
  }

  protected function drawPage() {
    
    if(sizeof($this->widgets)) {
      $this->page_elements['sidebar'] = implode('', $this->widgets);
    }

    // make body
    $body = elgg_view_layout($this->page_layout, $this->page_elements);
    // draw page
    echo elgg_view_page($this->page_elements['title'], $body, $this->page_shell);
  }

  public function __call($name,  $arguments) {
    $this->actionError();
  }
}