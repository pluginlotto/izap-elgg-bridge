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
 * retrieve and filters the entities according to  the specific category
 * uses
 *          $vars['category']
 *          $vars['selected']
 *
 */
$entity_types = get_registered_entity_types();
$registered = array();
$registered[''] = 'ALL';
foreach($entity_types['object'] as $type){
  $registered[$type] = elgg_echo('item:object:'.$type);
}
//c($entity_types['object']);

$category_guid = elgg_extract('category', $vars);
echo '<div class = "search_filter_dropdown">';
echo '<label>';
echo elgg_echo('izap-bridge:categories:search_in');
echo elgg_view('input/dropdown',array(
    'internalid' => 'entity_types',
    'options_values' => $registered,
    'value' =>elgg_extract('selected',$vars)
));
echo '</label>';
echo '</div>';
?>
<script type ="text/javascript">
  $('#entity_types').change(function(){
    $('#entity_types option:selected').each(function(){
      var type = $(this).val();
      $('#searched_items').html('LOADINGG............');
      elgg.get('/categories/ajax_list/<?php echo $category_guid?>/' + type, function(data){
        $('#searched_items').empty().append(data);
      });
    });
  });
</script>


