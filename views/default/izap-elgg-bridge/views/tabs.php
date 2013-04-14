<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version 1.0
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
*/
$unique_id = time();
if(sizeof($vars['tabsArray'])&&is_array($vars['tabsArray'])) {
  elgg_load_js('jquery.md5'); ?>
  <script type="text/javascript" language="javascript">
    jQuery.extend({
      toggleTabsByIzap : function funcToggleTabsByIzap(elm_id, selected) {
        var ul = $('ul', '#'+elm_id);
        $('li', ul).each(function() {
          $(this).removeClass();
          $('#contents-'+$(this).attr('id')).hide();
        });
        $('#'+selected).addClass('elgg-menu-item-all elgg-state-selected');
        $('#contents-'+selected).show();
        $.cookie('elgg_selected_tab_'+$.md5($(location).attr('href')), selected);
        return false;
      },

      tabsByIzap : function funcTabsByIzap(elm_id, selected) {
        var ul = $('ul', '#'+elm_id);
        $.toggleTabsByIzap(elm_id, selected);
        $('li', ul).bind('click', function(){
          $.toggleTabsByIzap(elm_id, $(this).attr('id'));
          return false;
        });
      }

    });

    $(document).ready(function(){
      var selected_var='<?php echo $vars['selected']?$vars['selected']:"" ;?>';
      if(selected_var) {
        selected = 'tabs-'+selected_var;
      } else {
        // selected
        var selected=$.cookie('elgg_selected_tab_'+$.md5($(location).attr('href')));
        if(selected == null) {
          selected='tabs-0';
        }
      }
      
      $.tabsByIzap('<?php echo $unique_id; ?>', selected);
    });
  </script>
  <div id="<?php echo $unique_id; ?>">
    <ul class="elgg-menu elgg-menu-filter elgg-menu-hz elgg-menu-filter-default">
    <?php foreach($vars['tabsArray'] as $n=>$tabArray) : ?>
      <li id="tabs-<?php echo $n;?>"><a href="javascript: void();"><?php echo $tabArray['title'] ;?></a></li>
    <?php endforeach ?>
    </ul>
  </div>
  <?php
  foreach($vars['tabsArray'] as $n=>$tabArray) {
    ?>
  <div id="contents-tabs-<?php echo $n;?>">
      <?php echo $tabArray['content'] ;?>
  </div>
  <?php }
    ?>
<?php
}