var actions = function (action, click_parent) {
    $("#" + action).removeClass('hidden');
    var continue_action = '';

    console_log('call for ' + action + " - click from: " + click_parent);
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
//TODO
            break;
        case 'register':
//TODO
            break;
        case 'learn_more':
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

$( document ).ready(function() {
    if ($("body").hasClass("touch_device")) {
        $('nav#menu-left').mmenu();
        $('nav#menu-right').mmenu({
            position:'right',
            counters:true
        });
        setClick();
        setMenuClick();
    } else {
        $("#header").hide();
    }
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
