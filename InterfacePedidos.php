<?php

class InterfacePedidos {

  private $server = 'http://dev.webilop.com/pedidos-online/';
  //private $server = 'http://pedidos-online/';
  private $cookieName = "wp_clipe";
  private $ivOption="wp_clipe_iv";
  private $salt="jjuhyfhjkkyftñyyuvyvyjd";

  public function InterfacePedidos() {

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
    /*//echo "$username-$password";
    if (empty($username) || empty($password)) {
      //login for the admin
      $this->options = get_option('pediodosonline_option_name');
      $username = $this->options['email'];
      $password = $this->options['password'];
    }*/
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
    /*echo '<br>post: <br>';
    print_r($data);
    echo "<br> request:" . $this->server . "$request <br> type:$type <br>";*/
    //echo "<br> request:" . $this->server . "$request <br> type:$type <br>";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->server . $request);
    switch ($type) {
      case "post":
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        break;

      case "get":
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        break;

      case "delete":
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        break;
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $json_response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code



    curl_close($ch);
    // get a json file and this is decode and after iterated with this
    $response = json_decode($json_response);
    if($status==302){
      echo "<h1>".__("an error 302 has occurred in the service of clipe, please try later or contact with admistrador service.","clipe")."</h1>";
      exit;
    }
   //echo "<br> status request: $status ";
   //echo "<br> json: $json_response <br>";
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
    $encrypt_password = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->salt, $token, MCRYPT_MODE_CBC, $iv);
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
    $decrypted_string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->salt, base64_decode($token), MCRYPT_MODE_CBC, $iv));
    return $decrypted_string;
  }

}

?>
