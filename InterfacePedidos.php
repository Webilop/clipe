<?php

class InterfacePedidos {

  private $server = null;
  private $cookieName = "wp_clipe";
  private $ivOption="wp_clipe_iv";
  private $debug = false;
  private $debugFirePHP = false;

  public function InterfacePedidos() {
    $apiVar = getenv('clipe_url_api');
    $this->server = $apiVar === false ? 'https://app.clipe.co/' : $apiVar;
  }

  /**
  * Create a private key to be used in encryption of data. It uses config var SECURE_AUTH_SALT as key.
  *
  * @return string Key string.
  */
  private function createPrivateKey(){
    $key = SECURE_AUTH_SALT . 'Ma7G1n0XJZZfCLiIy0cdMqt4yNgSrIRv';
    return substr($key, 0, 32);
  }

  public function verifyConnection() {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      return "connection is active :)";
    } else {
      $result = $this->login();
      return $result->status;
    }
  }

  public function logout() {
    setcookie($this->cookieName, "", time() - 3600, '/');
  }

  /*
   * login for at client or admin
   */

  public function login($username = "", $password = "", $onlyCheck = false) {
    if (empty($username) || empty($password)) {
      //login for the admin
      $this->options = get_option('pediodosonline_option_name');
      $username = $this->options['email'];
      $password = $this->options['password'];
    }
    if ($onlyCheck) {
      $result = $this->request('api/users/login.json', 'post', array('email' => $username, 'password' => $password, 'only_check' => "true"));
    }
    else {
      $result = $this->request('api/users/login.json', 'post', array('email' => $username, 'password' => $password));
      if ($result->status == "success") {
        $cookie_value = $this->encrypt($result->data->access_token);
        setcookie($this->cookieName, $cookie_value, time() + 3600*2, '/');
      }
    }
    return $result;
  }

  /*
   * handles all requests for pedidosonline.
   * type => get,post,delete.
   */

  public function request($request, $type = "get", $data = array()) {

    if ($this->debug) {
      echo '<br>post: <br>';
      print_r($data);
      echo "<br> request:" . $this->server . "$request <br> type:$type <br>";
      //echo "<br> request:" . $this->server . "$request <br> type:$type <br>";
    }
    if ( $this->debugFirePHP) {
      FB::log($type, 'Request ');
      FB::log($this->server . $request, 'Server: ');
      FB::log($data, 'Data: ');
    }

    $ch = curl_init();
    $options = get_option('pediodosonline_option_name');
    if(!isset($options['language']) || empty($options['language'])){
      $options['language']='eng';
    }
    switch ($type) {
      case "post":
        curl_setopt($ch, CURLOPT_POST, 1);
        $data['lang']=$options['language'];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        break;

      case "get":
        $request.="&lang=".$options['language'];
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        break;

      case "delete":
        $request.="&lang=".$options['language'];
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        break;
    }
    curl_setopt($ch, CURLOPT_URL, $this->server . $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $json_response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code

    curl_close($ch);
    // get a json file and this is decode and after iterated with this
    if ($this->debug) {
      echo "<br> status request: $status ";
      echo "<br> json: $json_response <br>";
    }
    if ( $this->debugFirePHP ) {
      FB::log($status, 'status');
      FB::log($json_response, 'json_response');
      FB::log($json_response, 'json_response');
    }
    $response = json_decode($json_response);
    if($status==302){
      echo "<h1>".__("An error 302 has occurred in the service of clipe, please try later or contact with admistrador service.","clipe")."</h1>";
      echo "<br> request:" . $this->server . "$request <br> type:$type <br>";
      exit;
    }

    return $response;
  }

  private function encrypt($token) {
    $iv=get_option($this->ivOption);
    if(!$iv){
      $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_RAND);
      update_option($this->ivOption, base64_encode($iv));
    }
    $iv = base64_decode($iv);
    // Encrypt $string
    $encrypt_password = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->createPrivateKey(), $token, MCRYPT_MODE_CBC, $iv);
    return base64_encode($encrypt_password);
  }

  public function decrypt($token) {
    if (empty($token)) {
      return $token;
    }
    $iv = get_option($this->ivOption);
    if ($iv) {
      $iv = base64_decode($iv);
    } else {
      return $token; //not iv save. should not happen, but just in case.
    }
    $decrypted_string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->createPrivateKey(), base64_decode($token), MCRYPT_MODE_CBC, $iv));
    return $decrypted_string;
  }

}
