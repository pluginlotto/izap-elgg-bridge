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
?>

<div class="izap-content">
  <div class="izap-head">
    <h3 >Categories</h3></div>
  <ul class="sidebarlist">
    <?php
    $categories_entities = elgg_get_entities(array(
                'type' => 'object',
                'subtype' => GLOBAL_IZAP_BRIDGE_CATEGORIES_SUBTYPE,
                'limit' => 100
            ));
    foreach ($categories_entities as $cat) {
      $link = IzapBase::setHref(array(
                  'context' => GLOBAL_IZAP_BRIDGE_CATEGORIES_PAGEHANDLER,
                  'action' => 'list',
                  'page_owner' => false,
                  'vars' => array('category' => $cat->guid)
              ));
    ?>
      <li>
        <a href="<?php echo $link ?>"><?php echo $cat->title ?></a>
      <?php
    }
      ?>
  </ul>
</div>