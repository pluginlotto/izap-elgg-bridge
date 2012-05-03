<?php

class IzapAdminController extends IzapController {

  protected $_page;
  protected $_view;

  public function __construct($page) {
    admin_gatekeeper();
    global $CONFIG;
    $cshop = new stdClass;

    $this->controller = GLOBAL_IZAP_CURRENT_CONTROLLER;
    $this->action = 'action' . ucfirst($page[0]);
    $this->_page = $page;
    $this->url_vars = $this->_page;
    $this->page_layout = $this->page_shell = 'admin';

    $cshop->view = $this->_view = 'admin/' . implode('/', $page);
    $this->page_elements['title'] = elgg_echo("admin:{$page[0]}");
    if (count($page) > 1) {
      $this->page_elements['title'] .= ' : ' . elgg_echo('admin:' . implode(':', $page));
    }

    if (method_exists($this, $this->action)) {
      elgg_admin_add_plugin_settings_menu();
      elgg_set_context('admin');

      elgg_unregister_css('elgg');
      $url = elgg_get_simplecache_url('js', 'admin');
      elgg_register_js('elgg.admin', $url);
      elgg_load_js('elgg.admin');

      elgg_register_js('jquery.jeditable', 'vendors/jquery/jquery.jeditable.mini.js');
      elgg_load_js('jquery.jeditable');
    }
    $CONFIG->cshop = $cshop;
  }

  public function __call($name, $arguments) {
    admin_page_handler($this->_page);
  }

  public function runAction() {
    call_user_func(array($this, $this->action), $this->_page);
  }

  public function actionCshop() {
    IzapBase::loadLib(array('plugin' => GLOBAL_IZAP_ELGG_BRIDGE, 'lib' => 'cshop'));
    switch( $this->_page[1] ) {
      case 'orders' :
        break;
      case 'order' :
        break;
      case 'cart' :
        break;
      case 'products' :
      default :
        $contents = cshop_list_products();
        break;
    }
    $this->page_elements['content'] = $contents;
    $this->drawPage();
    return ;
  }

  public function actionImage() {
    echo 'ok'; exit;
  }

}