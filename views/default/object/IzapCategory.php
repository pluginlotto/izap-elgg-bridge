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

$category = elgg_extract('entity', $vars);
echo '<div class="category_item">';
echo '<b>' . $category->getTitle() . '</b>';
if ($category->canEdit()) {
  echo  ' - '. elgg_view('output/url', array(
      'href' => IzapBase::setHref(array(
          'context' => 'ajax',
          'page_owner' => FALSE,
          'vars' => array('view', 'js', 'categories', 'edit'))) . '?guid=' . $category->guid,
      'text' => elgg_echo('izap-elgg-bridge:edit'),
      'class' => 'izap_category_edit_link'
  ));

  echo ' / ' . IzapBase::deleteLink(array(
      'guid' => $category->guid
  ));
}
?>
<br />
<?php echo $category->getDescription(); ?>
<?php echo '</div>';?>