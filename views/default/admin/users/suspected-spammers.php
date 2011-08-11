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

$users = elgg_get_entities_from_metadata(array(
        'type' => 'user',
        'metadata_name_value_pairs' => array(
                'name' => 'izap_spammer_hotness',
                'value' => '1',
                'operand' => '>='
        ),
        'order_by_metadata' => array(
                array(
                        'name' => 'izap_spammer_hotness',
                        'direction' => 'desc',
                ),
        ),
        'order_by' => '',
        'limit' => 999,
));
?>
<div class="elgg-module elgg-module-inline">
  <div class="elgg-body">
    <?php
    foreach($users as $user):
      ?>
    <div>
      <table  class="elgg-table-alt">
        <tbody>
          <tr class="u_row">
            <td><a href="<?php echo $user->getURL();?>"><?php echo $user->name;?></a></td>
            <td><a href="<?php echo IzapBase::setHref(array(
                'context' => 'ajax',
                'page_owner' => FALSE,
                     'vars' => array('view', 'js', 'antispam', 'userstats')))?>?guid=<?php echo $user->guid;?>" class="load_user_data" title="<?php echo $user->guid;?>">View data</a>
            </td>
            <td>
              <b><?php echo elgg_echo('izap-antispam:spammer_probability') . ': ' . (($user->izap_spammer_hotness/10) *100)?>%</b>
            </td>
          </tr>
        </tbody>
      </table>
      <span id="load_user_data_<? echo $user->guid;?>"></span>
    </div>
    <?php
    endforeach;
    ?>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

    $('.load_user_data').click(function(){
      var guid = this.title;
      $('#load_user_data_' + guid).html('<div align="center">loading.....</div>');
      elgg.get(this.href, function(data) {
        $('.izap_user_stats').remove();
        $('#load_user_data_' + guid).html(data);
      });
      return false;
    });

    $('.izap_close_stats').live('click', function(){
      $('#izap_user_stats_' + this.title).remove();
      return false;
    });
  });

</script>