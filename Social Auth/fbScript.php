<script>
  //appId      : '{582872148715721}',
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
      if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '582872148715721',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    var obj={"name": "", "email": "", "id": ""};
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me',  { locale: 'en_US', fields: 'name, email, id' }, function(response) {
      console.log('Successful login for: ' + response.name + ' : ' + response.id);
      obj.name = response.name;
      obj.email = response.email;
      obj.id = response.id;

      var jsonData=JSON.stringify(obj);
      
      $.post("../Api/fbSignupApi.php", jsonData, function(data){
        if(data == '1')
        {
          alert('Account has been created.');
          window.location.href = '../index.php';
        }
        else if(data == '0')
        {
          alert('An error has been occured!');
        }
        else if(data == '2')
        {
          alert('Logged in Successfully!');
          window.location.href = '../index.php';
        }
        });
    });
  }
</script>