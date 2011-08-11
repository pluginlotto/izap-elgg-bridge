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

/*
 * renders the output view for the categories
 *
 * @params:
 *    $vars['plugin_id]
 *    $vars['subtype']
 */
?>

<?php
$categories = IzapBase::pluginSetting(array(
            'plugin' => $vars['plugin_id'],
            'name' => 'izap_categories',
            'make_array' => TRUE,
        ));
if (!empty($categories)) {
  $categories_entities = elgg_get_entities(array('guids' => $categories));

  if($categories_entities){
  ?>

<div class="elgg-module  elgg-module-aside">
    <div class="elgg-head">
      <h3><?php echo elgg_echo('izap-elgg-bridge:categories'); ?></h3></div>
    <div class="elgg-body">
       <ul class="sidebarlist">
 <?php
    foreach ($categories_entities as $cat) {
      $link = IzapBase::setHref(array(
                  'context' => GLOBAL_IZAP_BRIDGE_CATEGORIES_PAGEHANDLER,
                  'action' => 'list',
                  'page_owner' => false,
                  'vars' => array($cat->guid, $vars['subtype']),
          'trailing_slash' => false,
              ));
    ?>
      <li>
        <a href="<?php echo $link ?>"><?php echo $cat->title ?></a>
<?php
    }?>
    </ul>
    </div>
</div>
 <?php }}