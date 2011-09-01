<?php

/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

add_translation('en', array(
    'izap-bridge:yes' => 'Yes',
    'izap-bridge:no' => 'No',
    'izap-bridge:enable' => 'Enable',
    'izap-bridge:disable' => 'Disable',
    'izap-bridge:invalid_entity' => 'Invalid entity',
    'item:annotation:blog_auto_save' => 'Blog draft',
    'item:annotation:generic_comment' => 'Comments',
    'izap-bridge:APIKEY' => 'API key',
    'izap-elgg-bridge:api_settings' => 'Pluginlotto.com settings',
    'izap-bridge:API_MSG' => 'If you don\'t have then register one at:
        <a href="http://www.pluginlotto.com/" target="_blank">http://www.pluginlotto.com/</a> with hostname "<strong>'.$_SERVER['HTTP_HOST'].'</strong>".',
    'izap-bridge:delete' => 'Delete',
    'izap-bridge:are_you_sure' => 'Are you sure',
    'izap-bridge:delete_success' => 'Deleted success fully',
    'izap-bridge:delete_error' => 'Error deleting entity. Error :: %s',
    'menu:page:header:izap' => 'iZAP',
    'admin:help' => 'Help',
    'admin:help:izap_help' => 'Help for the Plugin',
    'admin:help:izap_help?plugin=izap-elgg-bridge' => 'iZAP Bridge',
    'izap-elgg-bridge:save' => 'Save',
    'izap-elgg-bridge:saving' => 'Saving.....',
    'izap-elgg-bridge:edit' => 'Edit',
    'izap-elgg-bridge:close' => 'Close',
    'izap-bridge:add_api' => 'Click on the link to set izap-elgg-bridge API. <a href="/admin/plugin_settings/izap-elgg-bridge">izap-elgg-bridge</a>',
    
// for antispam
    'izap-bridge:consicutive_post_time' => 'Minimum time for two consicutive
          posts (Seconds)',
    'izap-bridge:consicutive_post_time_msg' => 'It will stop user for posting
          next entity, before the given interval of time',
    'izap-bridge:maximum_pings_for_spammer' => 'Maximum attempts by a user,
          to mark him/her as spammer',
    'izap-bridge:maximum_pings_for_spammer_msg' => 'It will mark the user as
          spammer, if he/she tries to post with in the above interval. (Usually for the scripts)',
    'admin:users:marked-spammers' => 'Marked spammers',
    'admin:users:suspected-spammers' => 'Suspected spammers',
    'izap_antispam:delete' => 'Delete',
    'izap-antispam:submit_spam' => 'Confirm as spammer',
    'izap-antispam:not_spammer' => 'Not spammer',
    'admin:izap-antispam:submit' => 'Submit spammer',
    'izap-antispam:spam' => 'Spammer data',
    'izap-antispam:table:name' => 'Name',
    'izap-antispam:table:username' => 'User Name',
    'izap-antispam:table:registeredtime' => 'Registration time',
    'izap-antispam:table:postcount' => 'Total posts',
    'izap-antispam:table:avgposttime' => 'Average post time',
    'izap-antispam:no data' => 'No entity for this user exists',
    'izap-antispam:wrong_entity' => 'Wrong entity',
    'izap-antispam:user_banned' => 'User has been banned',
    'izap_antispam:spam_log' => 'Spam Log',
    'izap-antispam:spammer_data' => "Spammer's data",
    'izap-antispam:table:totalfriends' => 'Total friends',
    'izap-antispam:table:totallogins' => 'Total logins',
    'izap-antispam:name' => 'Display name: ',
    'izap-antispam:table:userdata' => 'User Data',
    'izap-antispam:username' => 'User name: ',
    'izap-antispam:email' => 'Email: ',
    'izap-antispam:total' => 'Total no of ',
    'izap-antispam:confirm' => 'Are you sure want to mark %s, as spammer ? All of his/her data will be deleted and user will be banned.',
    'izap-antispam:slowdown_warning' => 'Slowdown Beamer',
    'izap-antispam:spammer_notice' => 'You don\'t have permission to post new data. Please contact the site admin.',
    'izap-antispam:ban_reason' => 'Found of doing spamming, banned by admin',
    'izap-antispam:spammer_probability' => 'Spammer probability',
    'izap-bridge:action_to_spammers' => 'Action to the spammer',
    'izap-bridge:spammer_act_yes' => 'Ban them automatically',
    'izap-bridge:spammer_act_no' => 'Send me report, but stop more entries from the user.',
    'izap-bridge:antispam:enable' => 'Enable anitspam for my site',
    'izap:bridge:mark_spammer' => 'Mark spammer',
    'izap:bridge:suspected_spammer' =>'Suspected spammer',
    'izap-elgg-bridge:spammer_suspected' => 'You have marked the user as suspected spammer',
   
    'izap:elgg:bridge:form_empty' => 'Title can not be left empty',
    // added on 06june11
    // payment gateway
    'izap_payment:no_gateway_found' => 'No payment gateway found, Please contact site administration',
    // PLUGIN SETTINGS
    'izap-elgg-bridge:bridge_settings' => 'iZAP-Bridge-Settings',
    'izap-elgg-bridge:enable_threaded_comments' => 'Enable threaded comments on all site',
    'izap-elgg-bridge:save' => 'Save',
    'izap-elgg-bridge:settings_saved' => 'Settings saved successfully.',
    'izap-elgg-bridge:error_saving_settings' => 'Error while saving settings.',
    'izap-elgg-bridge:plugin_data_access' => 'Should the plugin data access be limited to admin only',
    'izap-elgg-bridge:amazon_settings' => 'Amazon settings',
    'izap-elgg-bridge:general_settings' => 'General settings',
    'izap-bridge:AmazonsecretKEY' => 'Access key',
    'izap-bridge:applicationkey' => 'Secret key',
    'izap-bridge:choose_currency_for_site'=>'Currency of my site',
    'izap-bridge:choose_currency_msg'=>'This will be your default currency which will work for whole site',
    // errors and successes
    'izap-elgg-bridge:error:delete' => 'Error while deleting entity',
    'izap-elgg-bridge:error:setting_not_found' => 'Unable to find the setting file for <b>%s</b> plugin, so plugin is disabled.',
    // objects
    'item:object:IzapThreadedComments' => 'Threaded Comments',
    'izap-elgg-bridge:file_not_exists' => "Invalid url, please check the url spellings if you have typed it manually.",
    'izap-elgg-bridge:error_edit_permission' => "You don't have permission to save records.",
    'izap-elgg-bridge:error_empty_input_fields' => "Please fill all the required fields.",
    'izap-elgg-bridge:deleted' => "Deleted.",
    'izap-elgg-bridge:saved' => "Saved",
    'izap-elgg-bridge:mail_not_sent' => "Email not sent, server is busy right now. please try after some time.",
    'izap-elgg-bridge:your_name' => "Your name *",
    'izap-elgg-bridge:your_email' => "Your email *",
    'izap-elgg-bridge:your_contact' => "Contact no",
    'izap-elgg-bridge:your_friend_name' => "Your friend's name *",
    'izap-elgg-bridge:your_friend_email' => "Your friend's email *",
    'izap-elgg-bridge:message' => "Message *",
    'izap-elgg-bridge:cannotload' => 'Entity couldn\'t be loaded, please re-check the url, if you typed it manually.',
    'izap-elgg-bridge:comments' => 'Comments',
    'izap-elgg-bridge:send_to_friend' => 'Send to friend',
    'izap-elgg-bridge:not_valid_email' => 'Not valid email address',
    'izap-elgg-bridge:not_valid_entity' => 'Not valid entity',
    'izap-elgg-bridge:success_send_to_friend' => 'Your message has been successfully send.',
    'izap-elgg-bridge:error_send_to_friend' => 'Error sending message.',
    'izap-elgg-bridge:terms' => 'Terms & conditions',
    'izap-elgg-bridge:comment' => 'Comment',
    'izap-elgg-bridge:file_not_exists' => 'File doesn\'t exits',
    'izap-elgg-bridge:delete' => 'Delete',
    'izap-elgg-bridge:by' => 'by',
    'izap-elgg-bridge:date_day' => 'dd',
    'izap-elgg-bridge:date_month' => 'mm',
    'izap-elgg-bridge:date_year' => 'yy',
    'izap-elgg-bridge:cancel' => 'Cancel',
    'izap-elgg-bridge:threaded_comment_notify_subject' => 'You have a new comment at %s',
    'izap-elgg-bridge:new_comment' => 'There is new comment',
    'izap-elgg-bridge:yes' => 'Yes',
    'izap-elgg-bridge:no' => 'No',
    'izap_elgg_bridge:error_empty_input_fields' => 'Required fields are missing',
    'izap-elgg-bridge:rates' => "Rates",
    'izap-elgg-bridge:rateit' => "Rate it",
    'izap-elgg-bridge:text' => "Do you like it?",
    'izap-elgg-bridge:rated' => "You have rated it before.",
    'izap-elgg-bridge:badguid' => "Error, we haven't found any item to rate.",
    'izap-elgg-bridge:badrate' => "Rate must be from 0 to 5.",
    'izap-elgg-bridge:saved' => "Your rate has been saved.",
    'izap-elgg-bridge:error' => "Your izap-elgg-bridge could not be saved. Please try again.",
    'izap-elgg-bridge:rate-0' => "Very bad (0)",
    'izap-elgg-bridge:rate-1' => "Bad (1)",
    'izap-elgg-bridge:rate-2' => "Good (2)",
    'izap-elgg-bridge:rate-3' => "Cool (3)",
    'izap-elgg-bridge:rate-4' => "Amazing (4)",
    'izap-elgg-bridge:rate-5' => "Awesome (5)",

    // Exceptions
    'izap-elgg-bridge:Exception:mandatory_array_indexes' => 'Mandatory associative indexes: %s',
    'izap-elgg-bridge:Exception:no_metadata' => 'Undefined "%s" call.',
    'izap-elgg-bridge:Exception:no_method' => 'Undefined function name: "%s"',
    'izap-elgg-bridge:Exception:wrong_credential_or_connection_issue' => 'Could not obtain authenticated Http client object. %s',

    'izap-elgg-bridge:comments:on' => 'On',
    'izap-elgg-bridge:comments' => 'Comments',
    'izap-elgg-bridge:comments:off' => 'Off'
));
