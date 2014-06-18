MG_GAME_API = function ($) {
  return $.extend(MG_API, {
    turns : [],
    turn : 0,

    // Properties to be used by event-logging (see logEvent and sendLog)
    eventSent: false,
    events: [],
    
    // make sure the default game object always exists
    // this will be extended by each game
    game : {
      name : '',
      description: '',
      more_info_url : ''
    },
    
    /*
     * initialize games. called by a games implementation. ensures that default values and
     * needed parameter are set. will also initialize the API (to e.g. retrieve the SHARED SECRET)
     */
    game_init : function (options) {
    	 // console.log('game_init!');
      var settings = $.extend({
        onapiinit: MG_GAME_API.onapiinit,
        partner_wait_threshold: 20, // how many seconds will we wait until timeout
        partner_waiting_time: 0, // how many seconds did we wait until timeout
        message_queue_interval: 500,
        onunload : function () {return 'Quit ' + MG_GAME_API.game.name + '?';}
      }, options);
      
      MG_GAME_API.settings = $.extend(MG_GAME_API.settings, settings); //Pull from both defaults and supplied options
      
      MG_GAME_API.api_init(MG_GAME_API.settings);

      MG_GAME_API.observeOnBeforeUnload(settings.onunload);
    },
    
    /*
     * Callback called if the API has been successfully initialized
     */
    onapiinit : function () {
      MG_GAME_API.loadGame();
    },
    
    /*
     * Attempt to initialize a game via a GET call
     */
    loadGame : function () {
      // console.log('loadGame!');
      MG_API.waitForThrottleIntervalToPass(function () {
        MG_API.ajaxCall('/games/play/gid/' + MG_GAME_API.settings.gid , function(response) {
          if (MG_API.checkResponse(response)) {
            MG_GAME_API.game = $.extend(MG_GAME_API.game, response.game);
            MG_GAME_API.settings.ongameinit(response);
          }
        });  
      });
    },
    
    /*
     * helper function to extract license infos from the images as comma separated string
     * 
     * @param array licences The licences of the images 
     * @return string The licence names
     */
    parseLicenceInfo : function (licences) {
      var img_licence_info = [];
      $(licences).each(function (i, licence) {
        img_licence_info.push(licence.name);
      })
      return img_licence_info.join(", ");
    },
    
    /*
     * helper function to set an onbeforeunload callback handler
     * 
     * @param function callback Executed on the event a users leaves the page
     */
    observeOnBeforeUnload : function (callback) {
      $(window).bind('beforeunload', callback);
    },
    
    /*
     * helper function to clear the browser's before unload event
     */
    releaseOnBeforeUnload : function () {
      $(window).unbind('beforeunload');
    },
    
    /*
     * Interface to leave a message for another player in the active game's session
     * message queue. 
     * 
     * @param object message The message to leave JSON object 
     */
    postMessage : function (message) {
      if (message !== undefined && MG_GAME_API.game.played_game_id !== undefined) {
        MG_API.ajaxCall('/games/postmessage/played_game_id/' + MG_GAME_API.game.played_game_id , function (response) { 
            // no need to do anything errors are caught be the api 
          }, {
            type : 'post',
            data : {'message': message}
          }, true);
      }
    },
    
    /**
     * Adds an event to the event log.
     * @param {string} type The type of event (either 'click' or 'keypress')
     * @param {string} details Details about the event (button clicked, key pressed)
     */
    logEvent: function(actor, action, details) {
        MG_GAME_API.events.push({
            timestamp : new Date().getTime(),
            actor: actor,
            action: action,
            details : details
        });
    },

    /**
     * Sends the event log, adding a close window event at the end.
     */
    sendLog: function() {
        if (MG_GAME_API.eventSent) {
            return false;
        }
        MG_GAME_API.events.push({
            timestamp : new Date().getTime(),
            actor: "player",
            action: "end",
            details: "close window"
        });
        MG_API.ajaxCall('/games/play/gid/' + MG_GAME_API.settings.gid, null, {
            type: 'post',
            data: {
                eventlog : {
                    gameid: MG_GAME_API.settings.gid,
                    browser: navigator.userAgent,
                    events: MG_GAME_API.events,
                }
            }
        });

        MG_GAME_API.eventSent = true;
    },

    /**
     * Gets the printable character corresponding to the key being pressed
     * @param {KeyboardEvent} event an event sent by either keydown or keyup
     * @return {string} character (or one of Backspace, Enter) or null, if the event
     *     does not correspond to a printable character
     */
    getPrintableKey: function(event) {
      if (event.ctrlKey || event.metaKey) {
        return;
      }
      var keyCode = (event.keyCode || event.which);

      /* Case for A-Z and a-z */
      if (keyCode >= 65 && keyCode <= 90) {
        var key = String.fromCharCode(keyCode);
        if (!event.shiftKey) {
          key = key.toLowerCase();
        }
        return key;
      /* Case for 0-9 (non numpad) */
      } else if (!event.shiftKey && keyCode >= 48 && keyCode <= 57) {
        return String.fromCharCode(keyCode);
      /* Case for 0-9 (numpad) */
      } else if (keyCode >= 96 && keyCode <= 105) {
        return String.fromCharCode(keyCode - 48);
      } else {
        switch (keyCode) {
        case 8:
          return "Backspace";
        case 13:
          return "Enter";
        /* Cases for numpad punctuation */
        case 42:
        case 106:
          return "*";
        case 43:
        //case 107:   //case removed due to overlap
          return "+";
        case 45:
        //case 109:   //case removed due to overlap
          return "-";
        //case 46:    //case removed due to overlap
        case 110:
          return ".";
        case 47:
        case 111:
          return "/";
        /* Cases for punctuation above number keys */
        case 48:
          return ")";
        case 49:
          return "!";
        case 50:
          return "@";
        case 51:
          return "#";
        case 52:
          return "$";
        case 53:
          return "%";
        case 54:
          return "^";
        case 55:
          return "&";
        case 56:
          return "*";
        case 57:
          return "(";
        /* Cases for other punctuation */
        case 59:
        case 186:
          return event.shiftKey ? ":" : ";";
        case 61:
        case 107:
        case 187:
          return event.shiftKey ? "+" : "=";
        case 109:
        case 173:
        case 189:
          return event.shiftKey ? "_" : "-";
        case 188:
          return event.shiftKey ? "<" : ",";
        case 190:
          return event.shiftKey ? ">" : ".";
        case 191:
          return event.shiftKey ? "?" : "/";
        case 192:
          return event.shiftKey ? "~" : "`";
        case 219:
          return event.shiftKey ? "{" : "[";
        case 220:
          return event.shiftKey ? "|" : "\\";
        case 221:
          return event.shiftKey ? "}" : "]";
        case 222:
          return event.shiftKey ? "\"" : "'";
        default:
          return;
        }
      }
    },

    /*
     * Standardized interface to call the GameAPI action. Allowing games to
     * implement additional API call back functions
     * 
     * @param string method Name of the callback method
     * @param object parameter The parameter to be passed on to the callback method
     * @param function callback Called back on success  
     * @param object options Further options to extend the AJAX calls
     */
    callGameAPI : function (method, parameter, callback, options) {
      MG_API.waitForThrottleIntervalToPass(function () {
       MG_API.ajaxCall('/games/gameapi/gid/' + MG_GAME_API.settings.gid + '/played_game_id/' + MG_GAME_API.game.played_game_id,
          callback,
          $.extend({
           type : 'post', 
            'data': {
              'call': {'method':method}, 
              'parameter': parameter
             }
           }, options));     
        
      });
    }
  });
}(jQuery);

