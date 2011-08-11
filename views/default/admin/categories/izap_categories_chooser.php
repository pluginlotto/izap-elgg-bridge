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

$plugins = elgg_extract('plugins', $vars);
$categories = elgg_extract('categories', $vars);
$plugin_categories = elgg_extract('plugin_categories', $vars);

$plugins[0] = '--SELECT--';
ksort($plugins);
$select_plugins = elgg_view('input/dropdown', array(
    'internalid' => 'plugin',
    'internalname' => 'plugin',
    'options_values' => $plugins
        ));

$select_categories = elgg_view('input/checkboxes', array(
    'internalname' => 'categories',
    'options' => $categories,
        ));
?>

<div class="elgg-col-1of1">
  <div class="elgg-col elgg-col-1of2">
    <?php echo $select_plugins; ?>
  </div>

  <div class="elgg-col elgg-col-1of2 elgg-col-last">
    <?php
    echo $select_categories;
    echo elgg_view('input/submit', array(
        'internalid' => 'save',
        'value' => elgg_echo('izap-elgg-bridge:save')
    ));
    ?>
  </div>
</div>

<script type="text/javascript">
  var plugin_categories = <?php echo json_encode($plugin_categories); ?>;
  $('#plugin').change(function(){
    $('input:checkbox').attr('checked', false);
    if(this.value <= 0) {
      return ;
    }
    var plugin_array = plugin_categories[this.value];
    for (i=0;i<=plugin_array.length;i++){
      $('input:checkbox[value='+plugin_array[i]+']').attr('checked', true);
    }
  });

  $('#save').click(function() {
    var categories_array = new Array();
    var category_selected = false;
    
    $('input:checkbox:checked').each(function(){
      categories_array.push(this.value);
      category_selected = true;
    });

    // check all values
    if($('#plugin').val() <= 0) {
      alert('<?php echo elgg_echo('izap-elgg-bridge:select_category_options'); ?>');
      return false;
    }

    $('#save').attr('disabled', true).val('<?php echo elgg_echo('izap-elgg-bridge:saving');?>');
    elgg.action('<?php echo IzapBase::getFormAction('save_plugin_categorie', GLOBAL_IZAP_ELGG_BRIDGE) ?>', {
      data: {
        plugin: $('#plugin').val(),
        categories: categories_array
      },

      success:function(data){
        plugin_categories = data.output.updated_categories;
        elgg.system_messages();
        $('#save').attr('disabled', false).val('<?php echo elgg_echo('izap-elgg-bridge:save');?>');
      }
    });
  });
</script>