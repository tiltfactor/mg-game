NLP Scripts
===========

A collection of scripts that form the backend for the NLP server. Each script can be run on its own, from the commandline.
For more details on the script features, refer to the server README file. 

### generate\_ngram\_data

Currently has the script to generate letter-based bigram data. Two english corpora are provided. One of them, I stole from Peter Norvig's [page](http://norvig.com/spell-correct.html). The other is a file similar to Norvig's (contains gutenberg texts like *Alice In Wonderland* and *The Adventures of Tom Sawyer* )

    usage: python generate_bigram_data.py <file with corpus> <file to save data>

### possible_wordcheck

Checks if the input could be a possible word in the language. Uses the data file generated from the *generate_ngram_data* scripts. folder *data* contains some of such files, but you can rerun the script in *generate\_ngram\_data* folder with your own corpus (for example: if you are working with a different language) *norvig-big-bigram-letters* is the file used by default. If you use some other file (like the trigram ones or the ones you made), you might want to play around with the threshhold values in the file. And if you want to change the default (which gets used in the server too), just modify it's occurence in the script.

    usage: python possible_wordcheck.py <input> (uses the default bigram file)
           python possible_wordcheck.py <file with ngram data> -f <input_file>
           python possible_wordcheck.py <file with ngram data> -i <input>

### wordcheck

Utilizes the pyenchant library to check whether input is a word. Add words to *mywords.txt* if they are not being accepted. 

    usage: python wordcheck.py <input>
           python wordcheck.py -i <input> # ignores case
           python wordcheck.py -s <input> # for spelling suggestions


By Anup M. Dhamala, anupdhml at gmail dot com
