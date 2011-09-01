<?php
/***************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 ***************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

class IzapGYoutube extends IzapGoogle{
  private $uploading_type = 'direct'; // direct / browser are possible values.

  private $request = array(
      'developerkey' => 'AI39si7j4cyj-Dj99fJGEuOg5dx8BAh_o6V3MD35h9kGeYJIKOlEfVInMKgaXgjtV7BKg5a4W56WbjILhkQs7SFn2rV6G-noVg',
      'tokenhandler' => 'http://gdata.youtube.com/action/GetUploadToken',
      'nexturl' => '',
      'operationurl' => '',
      'homeurl' => '',
      'single_token' => '',
      'metadata' => array());
  private $video_entity;
  private $session_token;
  private $http_client;


  public function  __construct(array $vEntity = null) {
    Zend_Loader::loadClass('Zend_Gdata_YouTube');
    try{
      if(!(isset($vEntity['title']) && isset($vEntity['description']) &&
              isset($vEntity['category']) && isset($vEntity['keywords']))){
        throw new IzapException(elgg_echo('izap-elgg-bridge:Exception:mandatory_array_indexes',array('title, description, category, keywords')));
      }
      //merging all metadata passed through construct
      $this->request['metadata'] = array_merge($this->request['metadata'], $vEntity);
    }catch(IzapException $ze){
      register_error($ze->getMessage());
      return;
    }    
  }

  public function init_request(){

  }

  /*
   * undefined method calls handling. We are only entertaining getMethods and setMethods.
   */
  public function __call($functionName, $arguments){
  try{
    if(preg_match('/^getRequest([A-Za-z]+)/', $functionName,$matches)){
          $value_to_get = strtolower($matches[1]);
         if(!isset($this->request[$value_to_get])){
          throw new IzapException(elgg_echo('izap-elgg-bridge:Exception:no_metadata', array($value_to_get)));
        }
        return $this->request[$value_to_get];
      }elseif(preg_match('/^setRequest([A-Za-z]+)/', $functionName,$matches)){
        $index_to_set = strtolower($matches[1]);
        $this->request[$index_to_set] = $arguments;
      }elseif(preg_match('/^getMetadata/', $functionName,$matches)){ // returns whole metadata in term of array
        return $this->request['metadata'];
      }elseif(preg_match('/^get([A-Za-z]+)/', $functionName,$matches)){
      $value_to_get = strtolower($matches[1]);
        if(!isset($this->request['metadata'][$value_to_get])){
          throw new IzapException(sprintf(elgg_echo('izap-elgg-bridge:Exception:no_metadata'), $value_to_get));
        }
        return $this->request['metadata'][$value_to_get];
      }elseif(preg_match('/^set([A-Za-z]+)/', $functionName,$matches)){
        $index_to_set = strtolower($matches[1]);
        $this->request['metadata'][$index_to_set] = $arguments;
      }else{
        throw new IzapException(sprintf(elgg_echo('izap-elgg-bridge:Exception:no_method'), $functionName));
      }
    }
    catch(IzapException $ze){
      register_error($ze->getMessage());
    }
  }


  /*
   * private functions which are not suppose to be executed out side of this class
   */

  /**
   * Convenience method to obtain an authenticted Zend_Http_Client object.
   *
   * @return Zend_Http_Client An authenticated client.
   */
  private function getAuthSubHttpClient()
  {
      try {
          $httpClient = Zend_Gdata_AuthSub::getHttpClient($this->session_token);
      }
      catch (IzapException $iz) {
          register_error(elgg_echo('izap-elgg-bridge:Exception:wrong_credential_or_connection_issue',array(
                        $iz->getMessage())));
          return;
      }
      $httpClient->setHeaders('X-GData-Key', 'key='. $this->request['developer_key']);
      return $httpClient;
  }

  /**
 * Upgrade the single-use token to a session token.
 *
 * @param string $singleUseToken A valid single use token that is upgradable to a session token.
 * @return void
 */
  private function updateAuthSubToken()
  {
      try {
          $sessionToken = Zend_Gdata_AuthSub::getAuthSubSessionToken($this->request['single_token']);
      } catch (IzapException $e) {
          print 'ERROR - Token upgrade for ' . $this->request['single_token']
              . ' failed : ' . $e->getMessage();
          return;
      }
      $_SESSION['sessionToken'] = $sessionToken;
  }

}