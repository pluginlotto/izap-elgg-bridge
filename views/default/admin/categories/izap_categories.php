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

<div class="izap_categories_links">
  <a href="<?php
  echo IzapBase::setHref(array(
      'context' => 'ajax',
      'page_owner' => FALSE,
      'vars' => array('view', 'js', 'categories', 'edit')))
  ?>" id="izap_add_category" class="elgg-button elgg-button-action"><?php echo elgg_echo('izap-elgg-bridge:add_categories'); ?></a>
</div>

<div class="izap_categories_form" id="category_form"></div>

<br />
<div class="izap_categories_list">

  <?php
  echo elgg_view_title(elgg_echo('izap-elgg-bridge:category_list'));
  echo elgg_list_entities(array(
      'type' => 'object',
      'subtype' => GLOBAL_IZAP_BRIDGE_CATEGORIES_SUBTYPE,
  ));
  ?>
</div>


<script type="text/javascript">
  $('#izap_add_category, .izap_category_edit_link').click(function() {
    $('#category_form').empty().append('Loading.....').load(this.href);
    return false;
  });
</script>