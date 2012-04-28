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
<br />

<fieldset class="izap_admin_fieldset">
  <legend><?php echo elgg_echo('izap-elgg-bridge:api_settings'); ?></legend>
  <p>
  <label>
    <?php echo elgg_echo('izap-bridge:APIKEY'); ?><br />
    <?php
    echo elgg_view('input/text', array(
        'name' => 'params[izap_api_key]',
        'value' => IzapBase::pluginSetting(array(
            'name' => 'izap_api_key',
            'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
        )),
    ));
    ?>
  </label>
  <br />
  <?php echo elgg_echo('izap-bridge:API_MSG'); ?>
</p>
</fieldset>


<fieldset class="izap_admin_fieldset">
  <legend><?php echo elgg_echo('izap-elgg-bridge:amazon_settings'); ?></legend>
  <p>
      <label>
        <?php echo elgg_echo('izap-bridge:AmazonsecretKEY'); ?><br />
        <?php
        echo elgg_view('input/text', array(
            'name' => 'params[izap_amazon_secret_key]',
            'value' => IzapBase::pluginSetting(array(
                'name' => 'izap_amazon_secret_key',
                'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
            )),
        ));
        ?>
      </label>
      <br />

    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-bridge:applicationkey'); ?><br />
        <?php
        echo elgg_view('input/text', array(
            'name' => 'params[izap_app_key_key]',
            'value' => IzapBase::pluginSetting(array(
                'name' => 'izap_app_key',
                'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
            )),
        ));
        ?>
      </label>
      <br />
     </p>
</fieldset>

<fieldset class="izap_admin_fieldset">
  <legend><?php echo elgg_echo('izap-elgg-bridge:general_settings'); ?></legend>
  
<?php
echo IzapBase::input('radio', array(
    'input_title' => elgg_echo('izap-bridge:antispam:enable'),
    'options' => array(
        elgg_echo('izap-bridge:yes') => 'yes',
        elgg_echo('izap-bridge:no') => 'no',
    ),
    'value' => IzapBase::pluginSetting(array(
        'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
        'name' => 'izap_enable_antispam',
        'value' => 'yes'
    )),
    'name' => 'params[izap_enable_antispam]',
));
?>

<?php
if (IzapBase::pluginSetting(array(
            'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
            'name' => 'izap_enable_antispam',
            'value' => 'yes'
        )) == 'yes') {
  ?>

  <p>
    <label>
      <?php
      echo elgg_echo('izap-bridge:consicutive_post_time');
      echo '<br />';
      echo elgg_view('input/text', array(
          'name' => 'params[izap_consicutive_post_time]',
          'value' => IzapBase::pluginSetting(array(
              'name' => 'izap_consicutive_post_time',
              'value' => '30',
              'plugin' => GLOBAL_IZAP_ELGG_BRIDGE,
          )),
      ));
      ?>
    </label>
    <br />
  <?php echo elgg_echo('izap-bridge:consicutive_post_time_msg'); ?>
  </p>

  <p>
    <label>
      <?php
      echo elgg_echo('izap-bridge:maximum_pings_for_spammer');
      echo '<br />';
      echo elgg_view('input/text', array(
          'name' => 'params[izap_maximum_pings_for_spammer]',
          'value' => IzapBase::pluginSetting(array(
              'name' => 'izap_maximum_pings_for_spammer',
              'value' => '3',
              'plugin' => GLOBAL_IZAP_ELGG_BRIDGE
          )),
      ));
      ?>
    </label>
    <br />
  <?php echo elgg_echo('izap-bridge:maximum_pings_for_spammer_msg'); ?>
  </p>

  <p>
    <label>
      <?php
      echo elgg_echo('izap-bridge:action_to_spammers');
      ?>
    </label>
    <?php
    echo elgg_view('input/radio', array(
        'name' => 'params[izap_take_action_to_spammer]',
        'options' => array(
            elgg_echo('izap-bridge:spammer_act_yes') => 'yes',
            elgg_echo('izap-bridge:spammer_act_no') => 'no',
        ),
        'value' => IzapBase::pluginSetting(array(
            'name' => 'izap_take_action_to_spammer',
            'value' => 'no',
            'plugin' => GLOBAL_IZAP_ELGG_BRIDGE
        )),
    ));
    ?>
  </p>


<?php
}
?>
</fieldset>