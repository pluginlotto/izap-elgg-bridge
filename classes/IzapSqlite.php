<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version {version} $Revision: {revision}
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

class IzapSqlite {
  private $db_connection;
  private $db_file_location;
  private $query;
  private $statement;
  private $err_code_msg=array(23000=>'Already existing API.');

  public $message;
  public $code;
  public $rows_affected=0;
  /*
   * If set to false (e.g. due to PDOException), all queues and arrays will behave like
   * empty arrays, and no PDO queries will be made.
  */
  public static $pdoSupport = true;
  function  __construct($file_location) {
    try {
      $this->db_file_location = $file_location;
      $this->db_connection = $this->connect();
      $this->db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
      $this->exception_formater($e);
    }
  }

  public function execute($qry, $params=array(), $fetch_all=true, $fetch_style=PDO::FETCH_ASSOC) {
    if(!$this->db_connection) {
      return FALSE;
    }
    $this->query=$qry;
    try {
      $this->statement = $statement = $this->db_connection->prepare($this->query);
      $stmt_result = $statement->execute($params);
      $this->rows_affected = $statement->rowCount();
      preg_match('/SELECT/i',$this->query,$matches);
      switch(strtoupper($matches[0])) {
        case 'SELECT':
          return $fetch_all ? $statement->fetchAll($fetch_style) : $statement->fetch($fetch_style);
          break;
        default:
          return $stmt_result;
          break;
      }
    }
    catch(PDOException $e) {
      $this->exception_formater($e);
      return false;
    }
  }

  public function debug() {
    return $this->statement->debugDumpParams();
  }
  // to import sql file
  public function import_db($sql_file_path) {

  }

  //private function to connect database
  private function connect() {
    return new PDO('sqlite:'.$this->db_file_location);
  }
  //private function to format exception
  private function exception_formater(PDOException $e) {
    if(strstr($e->getMessage(), 'SQLSTATE[')) {
      preg_match('/SQLSTATE\[(\w+)\]: /', $e->getMessage(), $matches);
      $this->code = ($matches[1] == 'HT000' ) ? $matches[2] : $matches[1];
    }
    $this->message = isset($this->err_code_msg[$this->code])?$this->err_code_msg[$this->code]:$e->getMessage();
  }
}
