NLP Server
==========

A [flask](http://flask.pocoo.org/) based python web server that acts as a REST API for some Natural Language Processing tasks. Written primarily for use in [metadatagames](http://metadatagames.com/).

At the moment, the feature set is small and basic, but I hope to expand on it. Current highlight is the ability to check whether a given input is a *possible* English word or not. For instance, something like [*embiggen*](http://en.wikipedia.org/wiki/Lisa_the_Iconoclast#Embiggen_and_cromulent) or [*cromulent*](http://en.wikipedia.org/wiki/Lisa_the_Iconoclast#Embiggen_and_cromulent) are possible English words, as opposed to *bdskajb*. Rather than relying on a dictionary check for the input, which ignores words that don't appear widely in dictionaries (eg: *lol*. Some may not even consider this as an English word. But I digress -- this is perhaps not the place to debate on the status of such words.), the system here employs a [language model](http://en.wikipedia.org/wiki/Language_model) based on letter bigrams to decide whether an input is a possible word. Possible applications here include: system to detect online vanadalism, forbid random keyboard input but accept proper names or anything that could pass as a word, detect [borrowed words](http://en.wikipedia.org/wiki/Loanword) in a language, etc. (The main goal of the program was the second one in this list, so the default setup of the server scripts is geared towards that.)

The server currently works for English, but with an appropriate corpus, it should be extensible to other languages. Look at the *scripts* folder for more details on that. The scripts there are stand-alone python scripts and may be used independently of the server.

While the system here works fairly well, my implementation here is not the most excellent one. One day, I'll learn enough stats and re-work some parts.

My thanks to the [tiltfactor lab](http://www.tiltfactor.org/) for allowing me to work on this.


## Setup

Install flask with pip:

    sudo  pip install flask
This will install flask system-wide. If you prefer working with virtual environment, follow the instructions [here](http://flask.pocoo.org/docs/installation/).

For parts of the program to work, you'll need the [PyEnchant](http://pythonhosted.org/pyenchant/download.html) library.

    sudo pip install pyenchant

Now run the server:

    python run_nlpserver.py

Go to <http://localhost:8139> and you should see a simple welcome message.

Basic configuration is handled from *config.py* where things like server name and port can be changed. If you are using this in a production environment, set the *DEBUG* flag to *False* here. (Debug) messages get logged to *nlpserver.log* file, in the application directory. Make sure that you have a symlink pointing to *scripts* in the *nlpserver* folder, if you encounter module import errors related to the nlp scripts. If you can't form a symlink (eg: on Windows machines), just move the *scripts* folder inside *nlpserver*.


## Running the server with mod_wsgi

If you already have apache running and don't want a separate flask server running, you can install [mod\_wsgi](https://code.google.com/p/modwsgi/)
For Ubuntu/Debian, this will suffice:

    sudo apt-get install libapache2-mod-wsgi

After installing, copy the *example/nlpserver* file to */etc/apache2/sites-enabled*. Modify the user and group field, and also the paths to the app. Change the port from 8139 if you want, but make sure to add the line *Listen portnumber* to */etc/apache2/ports.conf*. Also, in the server directory, update the path in the file *nlpserver.wsgi*. Then enable the site with 

    sudo a2ensite nlpserver

Restart apache and you should be good to go. Note that the configuration of servername and port is now dependent on the apache config files, and not on *config.py*. (Debug) messages will also get logged to the apache log files, in addition to the *nlpserver.log* file in the application dir.

In case of problems with mod-wsgi: <http://flask.pocoo.org/docs/deploying/mod_wsgi/>. It might also help to set the log level to *info* in the apache configuration file.

The flask application here can be kept in any folder for which apache has read access, but for security, make sure that apache can't serve static files from that folder.


## Available views (with a mix of linguistics)

The commandline utility [curl](http://curl.haxx.se/) was used for these demonstrations, but anything capable of doing HTTP GET requests will work (meaning all web browsers)

#### /possible_wordcheck

Besides the standard words, accepts anything that looks like a word in the language. For instance, in English, this would accept something like [*cromulent*](http://en.wikipedia.org/wiki/Lisa_the_Iconoclast#Embiggen_and_cromulent) or other such neologisms. Also useful for proper nouns that are not necessarily found in a dictionary. Random keyboard input is forbidden straightaway (as long as it does not look like a word, of course) This last functionality works well for input length greater than 3/4 characters, but for some short inputs, it may raise false positives. Since the word-determination here is probabilistic in nature (by default, data based on letter [bigrams](http://en.wikipedia.org/wiki/Bigram) is used. Look in the folder *scripts/data/possible_wordcheck/data*), such results are bound to appear. A valid English word (i.e. something recorded in dictionaries) will always be accepted here though, so no false negatives.

    curl http://localhost:8139/possible_wordcheck?input=cromulent
    {
      "response": true
    }

    curl http://localhost:8139/possible_wordcheck?input=Rauner
    {
      "response": true
    }

    curl http://localhost:8139/possible_wordcheck?input=nkjsnd
    {
      "response": false
    }

    curl http://localhost:8139/possible_wordcheck?input=maxl
    {
      "response": false
    }

    curl http://localhost:8139/possible_wordcheck?input=english
    {
      "response": true
    }

#### /possible\_wordcheck\_strict

Works like *possible_wordcheck*, but the idea here is to try and completely forbid *non-native* (or [loan words](http://en.wikipedia.org/wiki/Loanword)) in the language. For instance, something like *Qatar* in English -- majority of English words have [q followed by u](http://english.stackexchange.com/questions/12326/why-is-q-followed-by-a-u). Or consider *juggernaut*, whose origins lie in [Sanskrit](http://en.wikipedia.org/wiki/Sanskrit) (this word has a really colorful [etymology](http://www.etymonline.com/index.php?term=juggernaut), btw). Or [*karaoke*](http://www.etymonline.com/index.php?term=karaoke), from Japanese. This route would forbid all these words. In contrast, current implementation of *possible_wordcheck* accepts cases like *Qatar*, *karaoke* and *juggernaut*. That is, */possible_wordcheck* accepts (or tries to accept) all stuff that you are likely to encounter in English, even though they are not true native words. This one is stricter. 

    curl http://localhost:8139/possible_wordcheck_strict?input=qatar
    {
      "response": false
    }

    curl http://localhost:8139/possible_wordcheck_strict?input=karaoke
    {
      "response": false
    }

    curl http://localhost:8139/possible_wordcheck_strict?input=juggernaut
    {
      "response": false
    }

But what about something like [*chandelier*](http://www.etymonline.com/index.php?term=chandelier), which was borrowed from [Old French](http://en.wikipedia.org/wiki/Old_French) back in the days? There are plenty of words like this in modern-day English though, that ultimately go back to French and Latin, and since words of this nature were abundant in the corpus I used to make the language model, it's impossible to detect them currently. However, using a corpus based on [Anglish](http://anglish.wikia.com/wiki/Headside) \(maybe something of this nature: [Uncleftish Beholding](https://groups.google.com/forum/message/raw?msg=alt.language.artificial/ZL4e3fD7eW0/_7p8bKwLJWkJ)\) would perhaps yield such a result, if desired.

    curl http://localhost:8139/possible_wordcheck_strict?input=chandelier
    {
      "response": true
    }

While the intended use for this is to check words, it works on the sentence level too.
If you are testing just from a browser, you won't have to spearate spaces like I did here. 

    curl "http://localhost:8139/possible_wordcheck_strict?input=This%20is%20an%20english%20sentence"
    {
      "response": true
    }

    curl "http://localhost:8139/possible_wordcheck_strict?input=yo%20chain%20hoina%20hai%saathi"
    {
      "response": false
    }

    curl "http://localhost:8139/possible_wordcheck_strict?input=quidquid%20latine%20dictum%20sit%20altum%20videtur"
    {
      "response": false
    }

The English sentence was accepted, but Nepali and Latin ones were not.

#### /borrowcheck

Same as *possible\_wordcheck\_strict*, except that the polarity is reversed. Returns true if input is determined as a borrowed word.

    curl http://localhost:8139/borrowcheck?input=karaoke
    {
      "response": true
    }

    curl http://localhost:8139/borrowcheck?input=orchestra
    {
      "response": false
    }

Note: Since data based on a bigram model is used by default, the program is currently unable to detect words like *tsunami* as borrowed. The letter sequence *ts* at the beginning is uncommon for English words, and using the trigram data for letters should detect words of this nature. (In fact, using the trigram data is better for detecting borrowed words, but bigram data is used by default as it was more accommodating in my tests when it came to deciding whether an input could be a valid English word (whether it be borrowed or native).

Also, this will not detect all non-native words. For instance, [*bandana*](http://www.etymonline.com/index.php?term=bandana) is from Sanskrit too, but the program considers this as not borrowed, since it is sufficiently English (cf. *band*) to fool the program. 

#### /wordcheck

Standard dictionary check, using the pyenchant library. If you want certain words to be accepted by the system, just add the word to the file *mywords.txt* (symlinked in the root folder from *scripts/wordcheck*) For instance, you could add *embiggen* to the list and it would be accepted. Note that adding words here will affect */possible_wordcheck* (but not */possible_wordcheck_strict*) because to catch cases like *Qatar*, */possible_wordcheck* uses the same dictionary check as this one (that procedure only affects false negatives -- things considered not words through the probabilistic method, like *Qatar* and *karaoke*, but that are actually used in English)

    curl http://localhost:8139/wordcheck?input=english
    {
      "response": true
    }

    curl http://localhost:8139/wordcheck?input=embiggen
    {
      "response": false
    }

#### /spellcheck

Check if the word is spelled correctly. Like */wordcheck*, but takes case into account.

    curl http://localhost:8139/spellcheck?input=procastination
    {
      "response": false
    }

    curl http://localhost:8139/spellcheck?input=qatar
    {
      "response": false
    }

    curl http://localhost:8139/spellcheck?input=Qatar
    {
      "response": true
    }

#### /spell_suggestions

This just uses the pyenchant library. If you want to write a spelling corrector from scratch, Peter Norvig has an excellent [guide](http://norvig.com/spell-correct.html).

    curl http://localhost:8139/spell_suggestions?input=procastination
    {
      "response": [
        "procrastination",
        "procrastinator",
        "procrastinate",
        "prognostication",
        "predestination",
        "preregistration",
        "overextension"
      ]
    }


## Usage

The available views output data as JSON and thus it provides a language independent solution, should you wish to perform these checks in your program. For instance, in javascript (with jquery), you could do something like this:

    // ajax call to the nlp api
    var word = "cromulent"
    $.ajax({
        type: "GET",
        url: "http://localhost:8139/possible_wordcheck",
        timeout: 5000,
        data: { input: word },
        dataType: "json",
        error: function( o ) {
            console.log('error with nlp api');
        }
    }).done(function( o ) {
        var is_possible_word = o.response;
        if (!is_possible_word) {
            console.log(word+' is not a word.');
        }
        else {
            console.log(word+' could be a word.');
        }
    });

If you are using python, just import the scripts as a module and work from there (*nlpserver/views.py* does exactly that.)
Each of the scripts in the folder *scripts* can be run on their own from the commandline, so a third way to use this collection would be to parse their shell output.


By Anup M. Dhamala, anupdhml at gmail dot com
