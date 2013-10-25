MG_GAME_PYRAMID = function ($) {
    return $.extend(MG_GAME_API, { // TODO make the extension work or remove
        toastStayTime:9900,
        toastBackgroundClass:'popup_gradient',
        //api_url : MG_PYRAMID.api_url,
        setLoginScreen:function(){
            // MG_API.curtain.hide();
            $("#login").show();
            $("#header .setting").hide();

            $("#facebook").off('click').on('click', function () {
                //  MG_API.curtain.show();
                //alert(MG_GAME_ONEUP.settings.arcade_url +"/site/login/provider/facebook?backUrl=" + encodeURIComponent(MG_GAME_ONEUP.settings.game_base_url + '/' + MG_GAME_ONEUP.settings.gid));
                //TODO fix   window.location.href = MG_GAME_PYRAMID.settings.arcade_url + "/site/login/provider/facebook?backUrl=" + encodeURIComponent(MG_GAME_PYRAMID.settings.game_base_url + '/' + MG_GAME_PYRAMID.settings.gid);
            });

            $('#login input#password').unbind("keypress").keypress(function (e) {
                if (e.which == 13) {
                    $("#btn_login").click();
                }
            });

        } // end set login screen
      // end ajaxCall

    })
};

var actions = function (action, click_parent) {
    $("#" + action).removeClass('hidden');
    var continue_action = '';

    console_log('call for ' + action + " - click from: " + click_parent);
   // MG_API.settings.api_url = MG_PYRAMID.api_url; // <--------------------------------------------we use it here
    //MG_GAME.oneup_hide_curtain();

    /*
     $("#header .words").hide();
     $("#header .back").hide();
     */
    switch (action) {
        case 'main_screen':

            break;
        case 'game_screen':

            break;
        case 'login':
            MG_API.ajaxCall('/user/sharedsecret', function (response) {
                if (MG_API.checkResponse(response)) {
                    if (response.shared_secret !== undefined && response.shared_secret !== "") {
                        MG_API.settings.shared_secret = response.shared_secret;
                        // MG_API.curtain.hide();
                        // MG_GAME_ONEUP.setLoginScreen();
                    } else {
                        throw "MG_API.init() can't retrieve shared secret";
                    }
                }
            });
            break;
        case 'register':
            MG_API.ajaxCall('/user/sharedsecret', function (response) {
                if(response.status === 'ok') {
                    MG_API.settings.shared_secret = response.shared_secret;
                }
                else {
                    throw "MG_API.init() can't retrieve shared secret";
                }
            });
            break;
        case 'learn_more':
            break;
        case 'logout':
            MG_API.ajaxCall('/user/logout', function () {
                MG_API.ajaxCall('/user/sharedsecret', function (response) {
                    if (MG_API.checkResponse(response)) {
                        if (response.shared_secret !== undefined && response.shared_secret !== "") {
                            MG_API.settings.shared_secret = response.shared_secret;
                            $('#mmenuLogin').removeClass('hidden');
                            $('#mmenuRegister').removeClass('hidden');
                            $('#mmenuLogout').addClass('hidden');
                            $('#mmenuPlay').addClass('hidden');
                            $("a[location='main_screen']").click();
                        } else {
                            throw "MG_API.init() can't retrieve shared secret";
                        }
                    }
                });
            });
            break;
        case 'how_to':
            break;
        default:
            console_log('action is unknown');
            break;
    }

    if (click_parent === '') {
        $("#content div:visible:eq(0)").hide();
        $("#" + action).slideUp().show();
    }
}

var setClick = function () {
    $("li.row div").click(function (e) {
        e.stopPropagation();
        $(this).find("a").click();
    });

    $("#content a[href='#']").off('click').on('click', function (e) {
        e.preventDefault();
        var location = $(this).attr('location');
        if (location != undefined) {
            var location = $(this).attr('location');
            $("#content div:visible:eq(0)").hide();
            actions(location, '');
        }
        return false;
    });
}

var setMenuClick = function () {
    $("a[location='main_screen']").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        actions('main_screen', 'menu');
    });
    $("a[location='how_to']").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        actions('how_to', 'menu');
    });
    $("a[location='login']").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        actions('login', 'menu');
    });
    $("a[location='register']").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        actions('register', 'menu');
    });
    $("a[location='learn_more']").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        actions('learn_more', 'menu');
    });
    $("a[location='logout']").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        actions('logout', 'menu');
    });
}

var device_ratio = 1,
    is_touch_device = is_touch_device();

if (is_touch_device) {
    device_ratio = window.devicePixelRatio;
}

function is_touch_device() {
    return !!('ontouchstart' in window) // works on most browsers
        || !!('onmsgesturechange' in window); // works on ie10
};

function console_log(logged_text) {
    console.log(logged_text);
}

var isLoggedUser = function() {
    if(MG_PYRAMID.isLogged == 'true'){
        MG_API.ajaxCall('/user/sharedsecret', function (response) {
            if(response.status === 'ok') {
                MG_API.settings.shared_secret = response.shared_secret;
            }
            else {
                throw "MG_API.init() can't retrieve shared secret";
            }
        });
        $('#mmenuLogin').addClass('hidden');
        $('#mmenuRegister').addClass('hidden');
        $('#mmenuLogout').removeClass('hidden');
        $('#mmenuPlay').removeClass('hidden');
    }
}

$( document ).ready(function() {
    MG_API.settings.api_url = MG_PYRAMID.api_url;
    //if ($("body").hasClass("touch_device")) {
    $('nav#menu-left').mmenu();
    $('nav#menu-right').mmenu({
        position:'right',
        counters:true
    });
    setClick();
    setMenuClick();
    isLoggedUser();

    $('.text_left .hover_btn ').off('click').on('click', function (e) {
        if(MG_PYRAMID.isLogged == 'false') {
            e.preventDefault();
            $().toastmessage("showToast", {
                text:'You must be logged in to play.',
                position:"tops-center",
                type:"notice",
                background:"white",
                color:"black",
                stayTime:MG_GAME_PYRAMID.toastStayTime,
                addClass:MG_GAME_PYRAMID.toastBackgroundClass
            });
            return false;
        }
    });

    $("#btn_login").off('click').on('click', function (e) {
        e.preventDefault();
        if ((jQuery.trim($("#login #username").val()).length + jQuery.trim($("#login #password").val()).length) < 1) {
            $().toastmessage("showToast", {
                text:"Username and passwords are required!",
                position:"tops-center",
                type:"notice",
                background:"white",
                color:"black",
                stayTime:MG_GAME_PYRAMID.toastStayTime,
                addClass:MG_GAME_PYRAMID.toastBackgroundClass
            });
        } else {
            MG_API.ajaxCall('/user/login', function (response) {
                    if (response.status === 'ok') {
                        $('#mmenuLogin').addClass('hidden');
                        $('#mmenuRegister').addClass('hidden');
                        $('#mmenuLogout').removeClass('hidden');
                        $('#mmenuPlay').removeClass('hidden');
                        $("a[location='main_screen']").click();
                    } else {
                        $().toastmessage("showToast", {
                            text:'Wrong username or password.',
                            position:"tops-center",
                            type:"notice",
                            background:"white",
                            color:"black",
                            stayTime:MG_GAME_PYRAMID.toastStayTime,
                            addClass:MG_GAME_PYRAMID.toastBackgroundClass
                        });
                    }
                }, {
                    type:'post',
                    data:{
                        password:jQuery.trim($("#login #password").val()),
                        login:jQuery.trim($("#login #username").val()),
                        rememberMe:jQuery.trim($("#login #rememberMe").prop('checked'))
                    }
                }
            );
        }
        return false;
    });

    $('#register #btn_register').off('click').on('click', function (e) {
        e.preventDefault();
        if ($("#register #username").val().length < 6 && $("#register #password").val().length < 6 && $("#register #verifyPassword").val() < 6 && $("#register #email").val().length < 5) {
            $().toastmessage("showToast", {
                text:'All fields are required.',
                position:"tops-center",
                type:"notice",
                background:"white",
                color:"black",
                stayTime:MG_GAME_PYRAMID.toastStayTime,
                addClass:MG_GAME_PYRAMID.toastBackgroundClass
            });
        } else {
            MG_API.ajaxCall('/user/register', function (response) {
                if (response.status === 'ok') {
                    $("a[location='main_screen']").click();
                }
                $().toastmessage("showToast", {
                    text:response.responseText,
                    position:"tops-center",
                    type:"notice",
                    background:"white",
                    color:"black",
                    stayTime:MG_GAME_PYRAMID.toastStayTime,
                    addClass:MG_GAME_PYRAMID.toastBackgroundClass
                });
            }, {
                type:'post',
                data:{
                    password:$("#register #password").val(),
                    username:$("#register #username").val(),
                    email:$("#register #email").val(),
                    verifyPassword:$("#register #verifyPassword").val()
                }
            });
        }
    });

    $("#facebook").off('click').on('click', function () {
        window.location.href = MG_PYRAMID.arcade_url + "/site/login/provider/facebook?backUrl=" + encodeURIComponent(MG_PYRAMID.game_base_url + '/' + MG_PYRAMID.gid);
    });



    /*    } else {
     $("#header").hide();
     }*/
});

/*
 $( document ).ready(function() {
 if (is_touch_device) {
 $("body").addClass('touch_device');
 }

 if (Modernizr.highres) {
 $("body").addClass('retina');
 }

 BrowserDetect.init();
 $("body").addClass(BrowserDetect.browser);
 })

 Modernizr.addTest('highres', function() {

 // for opera
 var ratio = '2.99/2';
 // for webkit
 var num = '1.499';
 var mqs = [
 'only screen and (-o-min-device-pixel-ratio:' + ratio + ')',
 'only screen and (min--moz-device-pixel-ratio:' + ratio + ')',
 'only screen and (-webkit-min-device-pixel-ratio:' + num + ')',
 'only screen and (min-device-pixel-ratio:' + num + ')'
 ];
 var isHighRes = false;

 // loop through vendors, checking non-prefixed first
 for (var i = mqs.length - 1; i >= 0; i--) {
 isHighRes = Modernizr.mq( mqs[i] );
 // if found one, return early
 if ( isHighRes ) {
 return isHighRes;
 }
 }
 // not highres
 return isHighRes;

 });

 var BrowserDetect = {
 init: function () {
 this.browser = this.searchString(this.dataBrowser) || "Other";
 this.version = this.searchVersion(navigator.userAgent) ||       this.searchVersion(navigator.appVersion) || "Unknown";
 },

 searchString: function (data) {
 for (var i=0 ; i < data.length ; i++) {
 var dataString = data[i].string;
 this.versionSearchString = data[i].subString;

 if (dataString.indexOf(data[i].subString) != -1) {
 return data[i].identity;
 }
 }
 },

 searchVersion: function (dataString) {
 var index = dataString.indexOf(this.versionSearchString);
 if (index == -1) return;
 return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
 },

 dataBrowser:
 [
 { string: navigator.userAgent, subString: "Chrome",  identity: "Chrome" },
 { string: navigator.userAgent, subString: "MSIE",    identity: "IE" },
 { string: navigator.userAgent, subString: "Firefox", identity: "FF" },
 { string: navigator.userAgent, subString: "Safari",  identity: "Safari" },
 { string: navigator.userAgent, subString: "Opera",   identity: "Opera" }
 ]

 };

 */
