<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 22.09.2015
 * @var string $appId
 * @var string $scope
 * @var string $fields
 * @var string $authUrl
 * @var string $redirectUrl
 * @var string|int $avatarWidth
 * @var string|int $avatarHeight
 */
;?>
<?php $script = "
    window.fbAsyncInit = function() {
        FB.init({
            appId      : ".$appId.",
            xfbml      : true,
            version    : 'v2.4'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = \"//connect.facebook.net/en_US/sdk.js\";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
            // Logged into your app and Facebook.
            fbauthenticate(response.authResponse);
        } else if (response.status === 'not_authorized') {
            // The person is logged into Facebook, but not your app.
            document.getElementById('status').innerHTML = 'Please log ' +
                'into this app.';
        } else {
            // The person is not logged into Facebook, so we're not sure if
            // they are logged into this app or not.
            document.getElementById('status').innerHTML = 'Please log ' +
                'into Facebook.';
        }
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId      : ".$appId.",
            cookie     : true,  // enable cookies to allow the server to access
                                // the session
            xfbml      : true,  // parse social plugins on this page
            version    : 'v2.2' // use version 2.2
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

        /*FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });*/

    };

    // Load the SDK asynchronously
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = \"//connect.facebook.net/en_US/sdk.js\";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.

    function fbauthenticate(authResponse){
        FB.api('/me', {fields: '".$fields."'},function(response) {
            //console.log(response);
            //console.log(authResponse);
            //console.log('".$redirectUrl."');
            var user_data = response;
            var auth_user_data = authResponse;
            FB.api('/'+response.id+'/picture??width=".$avatarWidth."&height=".$avatarHeight."',function (picture_response) {
                if (picture_response && !picture_response.error) {
                    user_data.picture = picture_response;
                }
                else{
                    console.log('picture_response not found');
                }
                $.ajax({
                        url:'".$authUrl."',
                        type: \"POST\",
                        dataType:  'json',
                        data: {user_data:user_data, auth_user_data:auth_user_data},
                        success: function(registration_response){
                            if(registration_response.status === 'success'){
                                window.location.href = '".$redirectUrl."';
                            }
                            else{
                                console.log(registration_response);
                            }
                        },
                        error: function(teste){
                            console.log('error');
                            //console.log(teste);
                        }
                    });
            });

        });
    }
    function facebookLogin(){
        FB.getLoginStatus(function(response){
            if (response.status === 'connected'){
                fbauthenticate(response.authResponse);
            }
            else{
                FB.login(function(response){
                    if (response.status === 'connected') {
                        // Logged into your app and Facebook.
                        fbauthenticate(response.authResponse);
                    } else if (response.status === 'not_authorized') {
                        // The person is logged into Facebook, but not your app.
                        document.getElementById('status').innerHTML = 'Please log ' +
                            'into this app.';
                    } else {
                        // The person is not logged into Facebook, so we're not sure if
                        // they are logged into this app or not.
                        document.getElementById('status').innerHTML = 'Please log ' +
                            'into Facebook.';
                    }
                },
                {scope: '".$scope."'});
            }
        });
    }
    $(document).ready(function(){
        $('#fb_login').click(function(){
            facebookLogin();
            return false;
        });
    });
";?>
<?php Yii::app()->clientScript->registerScript('fb_api', $script, CClientScript::POS_END);?>
<?=CHtml::link(
    Yii::t('userModule',"Login with Facebook"),
    '',
    array('class' => 'btn btn-big btn-fb b', 'id' => 'fb_login')
);?>
<!--<div class="fb-login-button" data-max-rows="1" onlogin="checkLoginState()" data-scope="<?/*=$scope;*/?>" data-size="xlarge" data-show-faces="false" data-auto-logout-link="true"></div>-->

<div id="status">
</div>
