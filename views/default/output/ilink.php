<?php
/* * **************************************************
 * PluginLotto.com                                  *
 * Copyrights (c) 2005-2011. iZAP                   *
 * All rights reserved                              *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

$powered_url = elgg_get_site_url() . "mod/".GLOBAL_IZAP_ELGG_BRIDGE."/_graphics/powered-by-izap.png";

// nothing here
echo '<div class="mts clearfloat float-alt">';
echo elgg_view('output/url', array(
  'href' => 'http://www.izap.in/',
  'text' => "<img src=\"$powered_url\" alt=\"Powered by iZAP\" width=\"106\" height=\"15\" />",
  'class' => '',
  'is_trusted' => true,
  'target' => "_blank"
));
echo '</div>';