      //Facebook connect for user registration start 
    window.fbAsyncInit = function () {
        FB.init({
            appId: "2039225979637950",
            channelUrl: "http://www.rothrsolutions.com/happycandidate/channel.html", // Channel File
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            picture: "http://www.fbrell.com/f8.jpg",
            xfbml: true  // parse XFBML
        });

        //FBLoginStatus();
    };
// Load the SDK Asynchronously
    (function (d) {
        var js, id = "facebook-jssdk", ref = d.getElementsByTagName("script")[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement("script");
        js.id = id;
        js.async = true;
        js.src = "http://connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
    }(document));
    function connectMe()
    {
        FB.login(function (response) {
            if (response.authResponse) {
                FB.api('/me/?fields=picture.width(160).height(160),email,id,birthday,link,name,gender', function (response) {
                    var params = "first_name=" + response.first_name + "&last_name=" + response.last_name + "&user_name=" + response.username + "&user_email=" + response.email + "&fb_id=" + response.id + "&fb_profile_picture=" + response.profile_picture + "&fb_gender=" + response.gender + "&fb_name=" + response.name + "&action=facebook_connect";
                    jQuery.ajax({
                        type: 'post',
                        url: '<?php echo $strFURL; ?>',
                        data: params,
                        success: function (msg) {
                            if (msg)
                            {
                                window.parent.location = strBaseUrl + "portal/index/monster/1";
                            }
                        },
                        error: function (e) {
                            window.location.reload();
                        }
                    });
                });
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        }, {"scope": "email,public_profile,user_photos"});
    }