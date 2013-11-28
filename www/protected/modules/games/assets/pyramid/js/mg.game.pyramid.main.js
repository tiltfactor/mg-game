MG_GAME_PYRAMID = function ($) {
    return $.extend(MG_GAME_API, { // TODO make the extension work or remove
        toastStayTime:9900,
        toastBackgroundClass:'popup_gradient',
        //api_url : MG_PYRAMID.api_url,
        setLoginScreen:function(){
            // MG_API.curtain.hide();
            $("#login").show();
            $("#header .setting").hide();


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
        case 'game_customize':
            $("#game_customize .note").remove();
            $("#game_customize").find("#listing").remove();
            $('#new_interest').attr('value', '');

            // allowed keys on the interest field
            $("input#new_interest").bind("keydown", function(event) {
                //console.log(event.which);
                if (event.shiftKey) { // When pressing shift, only allow these
                    return (
                        (event.which >= 97 && event.which <= 122) || // a-z
                        (event.which >= 65 && event.which <= 90) // A-Z
                    );
                }
                else {
                    return ( 
                        (event.which >= 97 && event.which <= 122) ||// a-z
                        (event.which >= 65 && event.which <= 90) || // A-Z
                        (event.which >= 48 && event.which <= 57) || // 0-9
                        event.which === 8 || event.which == 13 || event.which == 32 || // Backspace, Enter, space
                        event.which == 188 || event.which == 222 || // comma, apostrophe
                        event.which == 189 || event.which == 173 // dash, for different browsers
                    );
                }
            });

            $('input#new_interest').unbind("keypress").keypress(function (e) {
                if (e.which == 13) {
                    $("#game_customize #node").remove();
                    $("#game_customize").find('.note').remove();
                    var string = $('#new_interest').val();

                    // replace multiple whitespaces with a single space
                    // already done for db submissions, so not really needed here
                    //string = string.replace(/\s{2,}/g, ' '); 

                    // just to be safe, strip the special chars if still present
                    // forbid: `~!@#$%^&*()_=+{}|<>./?;:[]\"
                    // allowed: '-
                    string = string.replace(/[`~!@#$%^&*()_=+{}|<>./?;:\[\]\\"]/g, ""); 
                    //console.log(string);

                    var array = string.split(','),
                        counter_i = 0;
                    for (var i = 0; i < array.length; i++) {
                        MG_API.ajaxCall('/multiplayer/addInterest/gid/' + MG_PYRAMID.gid + '/interest/' + encodeURIComponent($.trim(array[i])), function (institution_response) {
                            counter_i++;
                            if (i === counter_i) {
                                $('#new_interest').attr('value', '');
                                $("#game_customize").find('.new_interest').append('<div class="note">The interest was added.</div>');
                            }
                        });
                    }
                    return false;
                }
            });
            //http://localhost/mggameserver/index.php/api/multiplayer/getInstitutions/gid/OneUp/
            MG_API.ajaxCall('/multiplayer/getInstitutions/gid/' + MG_PYRAMID.gid, function (institution_response) {
                var json = {};
                json.all_institution = institution_response;
                $("#template-favorite_institutions").tmpl(json).appendTo($("#game_customize")).after(function () {
                    // add click on an institution
                    // click on an institution
                    $("#list_institutions .institution").off('click').on('click', function (e) {
                        e.preventDefault();
                        var row = $(this);
                        MG_PYRAMID.institution_id = row.attr('institution_id');
                        MG_PYRAMID.back_location = 'game_customize';
                        // institution_info
                        actions('institution_info', '');
                    });
                });
            });
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
                    MG_API.ajaxCall('/user/register', function (response) { // we dont have that action
                        if (response.status === 'ok') {
                            MG_PYRAMID.isLogged = true;
                            MG_PYRAMID.username = $("#register #username").val();
                            MG_PYRAMID.email = $("#register #email").val();
                            $("#menu-right a[location='main_screen']").click();
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
            break;
        case 'learn_more':
            break;
        case 'logout':
            MG_API.ajaxCall('/user/logout', function () {
                MG_PYRAMID.isLogged = false;
                MG_PYRAMID.username = "";
                MG_PYRAMID.email = "";
                MG_API.ajaxCall('/user/sharedsecret', function (response) {
                    if (MG_API.checkResponse(response)) {
                        if (response.shared_secret !== undefined && response.shared_secret !== "") {
                            MG_API.settings.shared_secret = response.shared_secret;
                            $('#mmenuLogin').removeClass('hidden');
                            $('#mmenuRegister').removeClass('hidden');
                            $('#mmenuLogout').addClass('hidden');
                            $('#mmenuPlay').addClass('hidden');
                            $('#mmenuCustomize').addClass('hidden');
                            $('#mmenuAccount').addClass('hidden');
                            $("#menu-right a[location='main_screen']").click();
                        } else {
                            throw "MG_API.init() can't retrieve shared secret";
                        }
                    }
                });
            });
            break;
        case 'how_to':
            break;
        case 'account':
            $("#account_playlist").empty();
            $("#account_interest").empty();
            $("#account_bookmark").empty();
            $("#header").find('.setting').show();

            $("#account .row_link").each(function () {
                $(this).unbind('click').click(function (e) {
                    e.stopPropagation();
                    $(this).find("a").click();
                });
            });

            //getBookmarks
            MG_API.ajaxCall('/multiplayer/getBookmarks/gid/' + MG_PYRAMID.gid, function (account_bookmarks) {
                var json = {};
                json.bookmarked = account_bookmarks;
                $("#template-account_bookmark").tmpl(json).appendTo($("#account_bookmark")).after(function () {
                    function Slider(container) {
                        this.container = container;
                        this.imgs = container.find('img');
                        this.myImg = container.find('#my_image');
                        this.myImgPaddingLeftValue = parseInt(container.css('padding-left'), 10);
                        if (this.imgs.length > 0) {
                            this.imgWidth = (this.imgs[0].width || 0) + (this.myImgPaddingLeftValue || 0);
                        } else {
                            this.imgWidth = 0;
                        }
                        this.windowWidth = $(window).width();
                        this.allImagesWidth = this.getAllImagesWidth();
                        this.sliderMaxOffset = this.getSliderMaxOffset();
                        this.sliderOffset = 0;

                    }

                    ;

                    Slider.prototype.getAllImagesWidth = function () { // must be private
                        var tmpSum = 0;
                        var i = 0;
                        for (i; i < this.imgs.length; i++) {
                            tmpSum += this.imgs[i].width;
                        }
                        return tmpSum;
                    };


                    Slider.prototype.getSliderMaxOffset = function () { // must be private
                        var tmp = this.allImagesWidth / this.windowWidth;
                        var offset = Math.floor(tmp);
                        return offset;
                    };

                    Slider.prototype.transition = function (direction) {
                        var unit;
                        if (direction === "next" && !(mySlider.sliderOffset < mySlider.sliderMaxOffset)) { // no more images for slide right
                            return;
                        }
                        if (direction !== "next" && !(mySlider.sliderOffset > 0)) { // no more images for slide left
                            return;
                        }
                        if (this.windowWidth != 0) {
                            if (direction === "next") { // clicked on the next button
                                unit = '-=';
                                this.sliderOffset++;
                            }
                            else {
                                unit = '+=';
                                this.sliderOffset--;
                            }
                        }
                        this.container.animate(
                            {'margin-left':unit ? (unit + this.windowWidth) : this.windowWidth}
                        )
                    };

                    var container = $('#account .bookmark');
                    var mySlider = new Slider(container);

                    Hammer(container).off("swipeleft").on("swipeleft", function () { // swipeleft
                        mySlider.transition('next');
                    });

                    Hammer(container).off("swiperight").on("swiperight", function () { // swiperight
                        mySlider.transition('previous');
                    });
                    // add zoom to scaled and move swipe_left::swipe_right
                });
            });

            // Interests
            MG_API.ajaxCall('/multiplayer/getInterests/gid/' + MG_PYRAMID.gid, function (account_interest) {
                var json = {};
                json.interests = account_interest;
                $("#template-account_interest").tmpl(json).appendTo($("#account_interest")).after(function () {
                    $("#account_interest .delete").each(function () {
                        $(this).off('click').on('click', function (e) {
                            e.stopPropagation();
                            var row = $(this).closest('.row');
                            var row_id = row.attr('interest_id');
                            confirmPretty("Do you really want to remove the interest.", function () {
                                MG_API.ajaxCall('/multiplayer/removeInterest/gid/' + MG_PYRAMID.gid + '/id/' + row_id + '/', function (response) {
                                    row.remove();
                                });
                            })
                        });
                    });
                });
            });

            // List of all institutions that are not banned yet
            MG_API.ajaxCall('/multiplayer/getInstitutions/gid/' + MG_PYRAMID.gid, function (account_playlist) {
                var json = {};
                json.play_lists = account_playlist;
                $("#template-account_playlist").tmpl(json).appendTo($("#account_playlist")).after(function () {
                    $("#account_playlist").find(".row").unbind('click').click(function (e) {
                        e.stopPropagation();
                        $(this).find(".institution").click();
                    });

                    // click on an institution
                    $("#account_playlist .row .institution").each(function (event) {
                        $(this).off('click').on('click', function (e) {
                            e.stopPropagation();
                            var row = $(this).closest(".row");
                            MG_PYRAMID.institution_id = row.attr('institution_id');
                            MG_PYRAMID.back_location = 'account';
                            // institution_info
                            console.log("we are about to call -> actions(institution_info) from account");
                            actions('institution_info', '');
                        });

                    });

                    // delete
                    $("#account_playlist .delete").each(function () {
                        $(this).off('click').on('click', function (e) {
                            e.stopPropagation();
                            var row = $(this).closest('.row');
                            var row_id = row.attr('institution_id');
                            confirmPretty("Do you really want to disable medias from the institution.", function () {
                                MG_API.ajaxCall('/multiplayer/banInstitution/gid/' + MG_PYRAMID.gid + '/id/' + row_id + '/', function (response) {
                                    row.remove();
                                });
                            })
                        });
                    });
                });
            });

            break;
        case 'account_update':
            var userSettings = {};

            $("#header").find('.back').show(); // TODO this do not work
            console.log("we remove the hidden class of the arrow");
            $("#header").find('.back').removeClass('hidden'); // so we substitute with this
            $("#header").find('.setting').hide();
            $("#account_update").empty();

            MG_PYRAMID.back_location = 'account';

            userSettings.username = MG_PYRAMID.username;
            userSettings.email = MG_PYRAMID.email;
            $("#template-account_update").tmpl(userSettings).appendTo($("#account_update")).after(function () {
                $('#register input#email').unbind("keypress").keypress(function (e) {
                    if (e.which === 13) {
                        $('#account_update #btn_update').click();
                    }
                });

                $("#header").find('.back').off('click').on('click', function (e) {
                    e.preventDefault();
                    $("#header").find('.back').hide();
                    MG_PYRAMID.back_location = null;
                    actions('account', '');
                    return false;
                });

                $('#account_update #btn_update').off('click').on('click', function (e) {
                    e.preventDefault();
                    MG_API.ajaxCall('/user/update', function (response) {
                        if (response.status === 'ok') {
                            // What to do if success
                           // $("#header").find('.back').addClass('hidden'); // TODO  [not needed] work around for .show() not working
                            actions('main_screen', '');
                        }
                        $().toastmessage("showToast", {
                            text:response.responseText,
                            position:"tops-center",
                            type:"notice",
                            background:"white",
                            color:"black",
                            stayTime:MG_PYRAMID.toastStayTime,
                            addClass:MG_PYRAMID.toastBackgroundClass
                        });
                    }, {
                        type:'post',
                        data:{
                            password:$("#account_update #password").val(),
                            username:$("#account_update #username").val(),
                            email:$("#account_update #email").val()
                        }
                    });
                });
            });

            break;
        case 'institution_info':
            console.log("we are in case institution_info");
            $("#institution_info").empty();
            $("#header").find('.setting').hide();
           // $("#header").find('.back').show(); // <-- TODO this dont work and we can not see the upper left back arrow
            $("#header").find('.back').removeClass('hidden'); // so we substitute with this
            console.log("the arrow: ", $("#header").find('.back'));

            MG_API.ajaxCall('/multiplayer/GetInstitution/gid/' + MG_PYRAMID.gid + '/id/' + MG_PYRAMID.institution_id + '/', function (response) {
                var inst_remove = '<div class="right top_btn favorite" type="remove">REMOVE FROM PLAYLIST</div>',
                    inst_add = '<div class="right top_btn favorite" type="add">FAVORITE</div>';

                //show_institution
                $("#template-show_institution").tmpl(response).appendTo($("#institution_info")).after(function () {
                   // $('#institution_info').css('display', '')
                });
                if (response[0].isBanned === false) {
                    // Institution is in favorite list
                    $("#header").append(inst_remove);
                } else {
                    $("#header").append(inst_add);
                }

                addClickFav();

                function addClickFav() {
                    $("#header").find('.favorite').off('click').on('click', function () { // this is the upper-right "Remove from  Playlist"
                        $("#header").find('.favorite').remove();
                        if ($(this).attr('type') === 'remove') {
                            MG_API.ajaxCall('/multiplayer/banInstitution/gid/' + MG_PYRAMID.gid + '/id/' + MG_PYRAMID.institution_id + '/', function (response) {
                                setTimeout(function () {
                                }, 3000);
                                $("#header").append(inst_add);
                                addClickFav();
                            });
                        } else {
                            MG_API.ajaxCall('/multiplayer/unbanInstitution/gid/' + MG_PYRAMID.gid + '/id/' + MG_PYRAMID.institution_id + '/', function (response) {
                                setTimeout(function () {
                                }, 3000);
                                $("#header").append(inst_remove);
                                addClickFav();
                            });
                        }
                    });
                }

                $("#header").find('.back').off('click').on('click', function (e) {
                    e.preventDefault();
                    //$("#header").find('.back').hide(); // or  $("#header").find('.back').addClass('hidden')
                    $("#header").find('.back').addClass('hidden');
                    $("#header").find('.favorite').remove();
                    $("#header").find('.setting').show();
                    click_parent = MG_PYRAMID.back_location;
                    $("a[location='" + MG_PYRAMID.back_location + "']").click();
                    return false;
                });

            }) ;
            break;
        default:
            console_log('action is unknown');
            break;
    }

    if (click_parent === '') {
        $("#content div:visible:eq(0)").hide();
        $("#" + action).slideUp().show(); console.log("we slideUp for action: ", action);
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
    $("a[location='game_customize']").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        actions('game_customize', 'menu');
    });

    $("a[location='account']").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        actions('account', 'menu');
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
                        MG_PYRAMID.isLogged = true;
                        MG_PYRAMID.username = jQuery.trim($("#login #username").val());
                        $('#mmenuLogin').addClass('hidden');
                        $('#mmenuRegister').addClass('hidden');
                        $('#mmenuLogout').removeClass('hidden');
                        $('#mmenuPlay').removeClass('hidden');
                        $('#mmenuCustomize').removeClass('hidden');
                        $('#mmenuAccount').removeClass('hidden');
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

    $("#facebook").off('click').on('click', function () {
        window.location.href = MG_PYRAMID.arcade_url + "/site/login/provider/facebook?backUrl=" + encodeURIComponent(MG_PYRAMID.game_base_url + '/' + MG_PYRAMID.gid);
    });
}

var device_ratio = 1,
    is_touch_device = true;//is_touch_device();
    console.log("is_touch_device: ", is_touch_device);

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
        /* cause problems in chrome call shared secret 2nd time
        MG_API.ajaxCall('/user/sharedsecret', function (response) {
            if(response.status === 'ok') {
                MG_API.settings.shared_secret = response.shared_secret;
            }
            else {
                throw "MG_API.init() can't retrieve shared secret";
            }
        });
        */
        $('#mmenuLogin').addClass('hidden');
        $('#mmenuRegister').addClass('hidden');
        $('#mmenuLogout').removeClass('hidden');
        //$('#mmenuPlay').removeClass('hidden');
        $('#mmenuCustomize').removeClass('hidden');
        $('#mmenuAccount').removeClass('hidden');
    }
}

$(document).ready(function() {
    MG_API.settings.api_url = MG_PYRAMID.api_url;
   // if ($("body").hasClass("touch_device")) {
        $('nav#menu-left').mmenu();
        $('nav#menu-right').mmenu({
            position:'right',
            counters:true
        });
        setAuthentication();
        setClick();
        setMenuClick();
        isLoggedUser();
/*    $("#list_institutions .institution").on('click', function (e) {
        $('#institution_info').css('display', '')
    });*/
/*    } else {
        $("#header").hide();
        $('nav#menu-right').remove();
    }*/
});


function confirmPretty(text, onOk) {
    $("<div title='Confirmation'>" + text + "</div>").dialog({
        modal:true,
        dialogClass:'no-title',
        minWidth:450,
        maxWidth:600,
        buttons:[
            {
                text:"Cancel",
                id:"confirm_no",
                click:function () {
                    $(this).dialog('destroy').remove();
                }
            },
            {
                text:"Ok",
                id:"confirm_yes",
                click:function () {
                    onOk();
                    $(this).dialog('destroy').remove();
                }
            }
        ]
    });
}
