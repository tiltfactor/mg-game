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

var setAuthentication = function () {
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

$(document).ready(function() {
    MG_API.settings.api_url = MG_PYRAMID.api_url;
    if ($("body").hasClass("touch_device")) {
        $('nav#menu-left').mmenu();
        $('nav#menu-right').mmenu({
            position:'right',
            counters:true
        });
        setAuthentication();
        setClick();
        setMenuClick();
        isLoggedUser();
    } else {
        $("#header").hide();
        $('nav#menu-right').remove();
    }
});