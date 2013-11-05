/**
 * Created with JetBrains PhpStorm.
 * Date: 8/27/13
 * Time: 12:18 PM
 * To change this template use File | Settings | File Templates.
 */

usingWebAudio = false;

function Sound(source) {
    if (!window.audioContext) {
        if (typeof AudioContext !== 'undefined') {
            audioContext = new AudioContext();
            usingWebAudio = true;
        } else if (typeof webkitAudioContext !== 'undefined') {
            audioContext = new webkitAudioContext;
            usingWebAudio = true;
        } else {
            audioContext = false;
            usingWebAudio = false;
        }
    }
    if (!usingWebAudio) {
        return false;
    }

    var that = this;
    that.source = source;
    that.buffer = null;
    that.isLoaded = false;

    var getSound = new XMLHttpRequest();
    getSound.open("GET", that.source, true);
    getSound.responseType = "arraybuffer";
    getSound.onload = function() {
        audioContext.decodeAudioData(getSound.response, function (buffer) {
            that.buffer = buffer;
            that.isLoaded = true;
        })
    }
    getSound.send();
}

Sound.prototype.play = function (source) {
    if (!usingWebAudio) {
        playThis ();
    } else {
        if (this.isLoaded === true) {
            var playSound = audioContext.createBufferSource();
            playSound.buffer = this.buffer;
            playSound.connect(audioContext.destination);
            if (typeof playSound.noteOn === 'function') {
                playSound.noteOn(0 + 0.1);
            } else {
                playThis ();
            }
        }
    }

    function playThis () {
        var sound_info = {};
        sound_info.ogg_path = source.substr(0, source.length-3) + 'ogg'; //game_assets_uri + 'audio/sound' + num_sound + '.ogg';
        sound_info.mp3_path = source;
        $("#make_sound").remove();
        $("#template-make-sound").tmpl(sound_info).appendTo($("body")).after(function () {
            $('#make_sound')[0].play();
        });
    }
}