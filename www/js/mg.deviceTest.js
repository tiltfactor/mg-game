/**
 * Required modernizr lib
 */

var device_ratio = 1,
    is_touch_device = is_touch_device();

if (is_touch_device) {
    device_ratio = window.devicePixelRatio;
}

$( document ).ready(function() {
    if (is_touch_device) {
        $("body").addClass('touch_device');
    } else {
        $("body").addClass('no-touch_device');
    }

    if (Modernizr.highres) {
        $("body").addClass('retina');
    } else {
        $("body").addClass('no-retina');
    }

    BrowserDetect.init();
    $("body").addClass(BrowserDetect.browser);
})

Modernizr.addTest('highres', function() {

    try {
        if (window.devicePixelRatio > 1.25) {
            return true;
        }
    } catch (err) {
        return false;
    }

/*    if (window.devicePixelRatio > 1) {
        return true;
    }

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
console.log(mqs.length);
    // loop through vendors, checking non-prefixed first
    for (var i = mqs.length - 1; i >= 0; i--) {
        isHighRes = Modernizr.mq( mqs[i] );
        // if found one, return early
        if ( isHighRes ) {
            return isHighRes;
        }
    }
    // not highres
    return isHighRes;*/

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

function is_touch_device() {
    return !!('ontouchstart' in window) // works on most browsers
        || !!('onmsgesturechange' in window); // works on ie10
};

$.fn.centerHorizontal = function () {
    this.css("position", "absolute");
    if (this.outerWidth() < $(window).width()) {
        this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
        return this;
    }
};

$.fn.centerVertival = function () {
    this.css("position", "absolute");
    if (this.outerWidth() < $(window).width()) {
        this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
        return this;
    }
};
