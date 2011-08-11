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

class IzapAntiSpam {
  public $entity;
  public $user;
  public $consicutive_post_time;
  public $is_spammer = FALSE;
  public $current_time;
  private $action_file;

  public function __construct($entity) {
    $this->entity = $entity;
    $this->user = elgg_get_logged_in_user_entity();
    $this->consicutive_post_time = IzapBase::pluginSetting(array(
            'name' => 'izap_consicutive_post_time',
            'value' => '30',
            'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
    ));
    $this->consicutive_post_tries = IzapBase::pluginSetting(array(
            'name' => 'izap_maximum_pings_for_spammer',
            'value' => '3',
            'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
    ));
    $this->current_time = time();
    $this->action_file = elgg_get_plugins_path() . GLOBAL_IZAP_ELGG_BRIDGE . '/actions/admin/submit_spammer.php';
  }

  public function isSpammer() {
    if($this->user->izap_is_spammer === 'yes') {
      return TRUE;
    }

    return FALSE;
  }

  public function lastAction() {
    if((int)$this->user->izap_last_posted <= 0) {
      $this->user->izap_last_posted = $this->current_time;
    }

    $last_action = $this->current_time - $this->user->izap_last_posted;
    // gets average post time between last to post
    $avg_post_time = round ($this->current_time - ($this->current_time + $this->user->izap_last_posted)/2);
    // calculates the avg time for overall posts
    $avg_post_time = round (($this->user->izap_avg_post_time + $avg_post_time) / 2);

    // again update the last_posted meta, as now this is the latest entity
    $this->user->izap_last_posted = $this->current_time;
    $this->user->izap_avg_post_time = $avg_post_time;

    if($this->user->izap_avg_check_time <= 0) {
      $this->user->izap_avg_check_time = $this->user->izap_avg_post_time;
    }

    return $last_action;
  }

  public function canPost() {
    // check for if antispam is enabled in settings, send true if it is disabled
    if(!$this->isEnabled()) {
      return TRUE;
    }

    // if already marked as sapammer
    if($this->isSpammer()) {
      register_error(elgg_echo('izap-antispam:spammer_notice'));
      return FALSE;
    }

    // check for the admins
    if(isadminloggedin()) {
      return TRUE;
    }

    // low level
    if($this->lastAction() < $this->consicutive_post_time) {
      return $this->firstCheck();
    }else {
      // reset the consicutive tries
      $this->user->izap_consicutive_try = 0;
    }

    // moderate level
    if($this->isBetweenAvgInterval()) {
      return $this->secondCheck();
    }

    return TRUE;
  }

  public function firstCheck() {
    $this->user->izap_consicutive_try++;
    //register_error(elgg_echo('izap-antispam:slowdown_warning'));
    // if user exceedes the limit
    if($this->user->izap_consicutive_try > $this->consicutive_post_tries) {
      $this->user->izap_consicutive_try = 0;
      $this->markSpammer();
      return FALSE;
    }

    return TRUE;
  }

  public function secondCheck() {
    $this->user->izap_spammer_hotness++;
    if($this->user->izap_spammer_hotness >= 10) {
      $this->markSpammer();
      return FALSE;
    }

    return TRUE;
  }

  public function isBetweenAvgInterval($diff = 60) {
    $first_avg = $this->user->izap_avg_check_time;
    $avg_post_time = $this->user->izap_avg_post_time;
    $start_range = $first_avg - $diff;
    $finish_range = $first_avg + $diff;

    //echo $first_avg, '<br />', $avg_post_time, '<br />', $start_range, '<br />', $finish_range, '<br />', $this->user->izap_spammer_hotness;
    if($avg_post_time > $start_range && $avg_post_time < $finish_range) {
      return TRUE;
    }else {
      $this->user->izap_avg_check_time = $this->user->izap_avg_post_time;
      $this->user->izap_spammer_hotness--;
    }

    return FALSE;
  }

  public function isEnabled() {
    $enable = IzapBase::pluginSetting(array(
        'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
        'name' => 'izap_enable_antispam',
        'value' => 'yes'
    ));if($enable == 'yes') {
      return TRUE;
    }

    return FALSE;
  }
  
  public function markSpammer() {
    register_error(elgg_echo('izap-antispam:spammer_notice'));
    $this->user->izap_is_spammer = 'yes';
    if(IzapBase::pluginSetting(array(
            'name' => 'izap_take_action_to_spammer',
            'value' => 'no',
            'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
            )) == 'yes') {
      set_input('guid', $this->user->guid);
      include $this->action_file;
    }
  }

  public function unMarkSpammer() {
    $this->user->izap_is_spammer = 'no';
    $this->user->izap_spammer_hotness = 0;
  }
}