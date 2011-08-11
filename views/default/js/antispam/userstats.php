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

$user_guid = get_input('guid');
$user = elgg_get_entities(array('guids' => $user_guid));
$user = $user[0];
$total_post = 0;
if($user instanceof ElggUser) {
  $entities = elgg_get_entities(array(
          'type'=>'object',
          'owner_guid' => $user->guid,
          'limit' => 9999

  ));
  if($entities) {
    foreach($entities as $entity) {
      if(method_exists($entity, 'getTitle')) {
        $title = $entity->getTitle();
      }else {
        $title = $entity->title;
      }
      $content_array['item:' .$entity->getType() . ':'. $entity->getsubtype()][] = array(
              'title' => $title,
              'description' => $entity->description,
              'url'=> $entity->geturl(),
              'time_created' => $entity->time_created

      );
      $total_post++;
    }
  }

  $annotations = elgg_get_annotations(array('owner_guid' => $user->guid, 'limit' => 9999));
  if($annotations) {
//    c($annotations);
    foreach($annotations as $annotation) {
      $content_array['item:' .$annotation->type . ':'. $annotation->name][] = array(
              'title' => $annotation->value,
              'description' => $annotation->value,
              'url'=> $annotation->geturl(),
              'time_created' => $annotation->time_created

      );
      $total_post++;
    }
  }
  ?>
<div class="izap_user_stats" id="izap_user_stats_<?php echo $user->guid;?>">
  <div class="elgg-module elgg-module-inline">
    <div class="elgg-body">
      <table  class="elgg-table-alt">
        <tbody>
          <tr class="odd">
            <th><?php echo elgg_echo('izap-antispam:table:userdata');?></th>
            <th><?php echo elgg_echo('izap-antispam:table:registeredtime');?></th>
            <th><?php echo elgg_echo('izap-antispam:table:postcount');?></th>
            <th><?php echo elgg_echo('izap-antispam:table:avgposttime');?></th>
            <th><?php echo elgg_echo('izap-antispam:table:totalfriends');?></th>
            <th><?php echo elgg_echo('izap-antispam:table:totallogins');?></th>
          </tr>

          <tr class="even">
            <td><b><a href="<?php echo $user->getURL()?>" target="_blank"><?php echo $user->name;?></a>
                <br /><?php echo $user->email;?></b></td>
            <td> <?php echo date('j M Y',$user->time_created);?></td>
            <td> <?php echo (int)$total_post;?></td>
            <td> <?php echo IzapBase::formattedTime($user->izap_avg_post_time);
  ;?></td>
            <td> <a href="<?php echo $vars['url'];?>pg/friends/<?php echo $user->username?>"><?php echo count($user->getFriends('',9999));?></a></td>
            <td> <?php echo (int)$user->izap_total_logins;?></td>
          </tr>
        </tbody>
      </table>

      <ol>
          <?php
          foreach($content_array as $type => $array) :
            echo '<li><div class="contentWrapper">'.elgg_echo('izap-antispam:total').'<b>'.elgg_echo($type).': '.count($content_array[$type]).'</b></div>';
            if(sizeof($array)) {
              echo '<ol>';
              foreach($array as $val) :
                echo '<li>';
                echo '<a href = "'.$val['url'].'" target ="_blank">'.$val['title'].'</a> ';
                echo '(' .elgg_get_friendly_time($val['time_created']) . ')';
                echo '</li>';
              endforeach;
              echo '</ol><br />';
            }
            echo '</li>';
          endforeach;
  ?>
      </ol>
      <div align = "center">
          <?php echo elgg_view('output/confirmlink',array(
          'href' => IzapBase::getFormAction('not_spammer', GLOBAL_IZAP_ELGG_BRIDGE) .'?guid='.$user->guid,
          'text' => elgg_echo('izap-antispam:not_spammer'),
  ));?>
        - 
          <?php echo elgg_view('output/confirmlink',array(
          'href' => IzapBase::getFormAction('submit_spammer', GLOBAL_IZAP_ELGG_BRIDGE) .'?guid='.$user->guid,
          'text' => elgg_echo('izap-antispam:submit_spam'),
          'confirm' => sprintf(elgg_echo('izap-antispam:confirm'), $user->name . '(' . $user->email . ')'),
  ));?>
        - <a href="#" class="izap_close_stats" title="<?php echo $user->guid;?>">Close</a>
      </div>
    </div>
  </div>
</div>
  <?php
}else {
  echo elgg_echo('izap-antispam:wrong_entity');
}