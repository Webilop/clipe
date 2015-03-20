function login(){
 var formData = new FormData();
  email=jQuery.trim(jQuery("#login_email").val());
  password=jQuery.trim(jQuery("#login_password").val());
  if(email=="" || password==""){
    return false;
  }
  formData.append('action', 'pedidosonline_client_login');
  formData.append('email', email);
  formData.append('password', password);
  jQuery.ajax({
    type: 'POST',
    url: 'wp-admin/admin-ajax.php',
    contentType: false,
    processData: false,
    data: formData,
    beforeSend: function() {
      console.log('wait');
    },
    success: function(response) {
      json = jQuery.parseJSON(response);
      console.log(json);
      if (json.status=="success") {
        setCookie('wp_pedidosonline',json.data.access_token,3600);
        //jQuery.cookie('wp_pedidosonline', json.data.acces_token, { expires: 1 });
        console.log(':)');
       //document.location.href=json.redirect;
      }else{
        console.log(':(');
      }
    }
  });
}

function setCookie(cname, cvalue, seconds) {
    var d = new Date();
    d.setTime(d.getTime() + seconds);
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

jQuery(document).ready(function($) {
  //jQuery("#submit").click(login);
});


