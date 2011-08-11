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


class IzapSpamLogger extends IzapSqlite {
  public $dump_file;

  function __construct() {
    global $CONFIG;
    $this->dump_file = $CONFIG->dataroot . 'test7.db';
    try {
      parent::__construct($this->dump_file);
      $this->create();
    }
    catch(PDOException $e) {
      register_error($this->message);
    }
  }

  public function create() {
    try {
      $this->execute("create table spammer
        (guid INTEGER,
        username VARCHAR(25),
        mail_id VARCHAR(25),
        ip VARCHAR(24),
        post_type VARCHAR(10),
        post_title VARCHAR(100),
        post_content TEXT)");
    }
    catch(PDOException $e) {
      register_error($this->message);
    }
  }

  public function insert($user) {
    try {
      $query = 'Insert into spammer(guid,username,mail_id,ip,
        post_type,post_title,post_content) values(
    "'.$user['guid'].'",
    "'.$user['username'].'",
    "'.$user['email'].'",
    "'.$user['ip'].'",
    "'.$user['type'].'",
    "'.sanitise_string(str_replace('"', '&quot;', $user['title'])).'",
    "'.sanitise_string(str_replace('"', '&quot;', $user['content'])).'")';
      $return = $this->execute($query);
      return true;
    }
    catch(PDOException $e) {
      register_error($this->message);
    }
  }

  public function upload() {
    $curl = new IzapCurl('http://elgg18.pluginlotto.com/spam_dump/index.php');
    $post_params = array(
      'api_key' => IzapBase::APIKEY(),
      'domain' => base64_encode(strtolower($_SERVER['HTTP_HOST'])),
      'file' => "@{$this->dump_file}",
    );

      $curl->setopt(CURLOPT_POST, TRUE);
      $curl->setopt(CURLOPT_POSTFIELDS, $post_params);
      $data = $curl->exec();
      if($data['status']) {
        @unlink ($this->dump_file); // delete file once it is uploaded
        return TRUE;
      }

      return FALSE;
  }
}