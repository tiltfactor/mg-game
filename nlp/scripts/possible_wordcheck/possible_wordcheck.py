#!/usr/bin/env python

import sys, os
import json
import logging
import re
#from pprint import pprint # pretty print, for dictionaries


THRESHOLD_PROB=0.00001 # using bigram
#THRESHOLD_PROB=1e-10 # using trigram

#  good pick would be sth lower than the lowest value in the used bigram
FALLBACK_PROB=0.0001 


def get_str_prob(input_str, bigram_dist): 
    input_str = input_str.lower()
    #input_str = input_str.lower() + ' '
    str_prob=1

    for i, letter in enumerate(input_str):
        if i==0:  #no context, the beginning of input
            #context = '#'
            context = ' '
        else:
            context = input_str[i-1]  #previous letter

        # for trigram 
        # TODO: Integrate this
        #elif i==1:  #single letter as context
            #context = input_str[i-1]
        #else:
            #context = input_str[i-2] + input_str[i-1]  #previous 2 letters

        if context not in bigram_dist: 
            str_prob*=FALLBACK_PROB
        elif letter not in bigram_dist[context]:
            str_prob*=FALLBACK_PROB
        else:
            str_prob*=bigram_dist[context][letter]

    # My attempt to normalize the probability against the length of the input
    # This works but surely, there's a standard way of doing this...
    return str_prob * (10 ** (len(input_str)-1))
    #return str_prob


# Match consecutive repeat(>3) of alphanumeric character anywhere in the string
def has_repeats(input_str):
    return re.search(r'((\w)\2{3,})', input_str)


def is_possible_word(input_str, bigram_filename='data/norvig-big-bigram-letters',
                     repeat_check=True, logger=None, colors=False):
    # if characters are repeated way too many times, decide straightaway
    # our bigrams and trigrams were found to be lacking for some of these...
    if repeat_check and has_repeats(input_str): 
        if logger: logger.info("%s has more than 3 consecutive repeats so not a word", input_str);
        return False

    possible_word = True

    # fixes paths
    __dir__ = os.path.dirname(os.path.abspath(__file__))
    bigram_file = os.path.join(__dir__, bigram_filename)

    with open(bigram_file) as f:
        bigram_dist = json.load(f)
    # test
    #pprint(bigram_dist)
    #with open('restored_data', 'w') as f:
        #json.dump(bigram_dist, f)

    word_prob = get_str_prob(input_str, bigram_dist)
    if word_prob < THRESHOLD_PROB:
        possible_word = False

    if logger: 
        #print input_str, word_prob
        logger.debug("%s %s", input_str, word_prob);

        c = bcolors();
        #if not sys.stdin.isatty():  c.disable() # print colorful output only from a console
        if not colors:  c.disable()

        if possible_word:
            #print c.OKBLUE + input_str + c.ENDC + ' could be a word.'
            logger.info("%s", c.OKBLUE + input_str + c.ENDC + ' could be a word.');
        else:
            #print c.FAIL + input_str + c.ENDC + ' is not a word.'
            logger.info("%s", c.FAIL + input_str + c.ENDC + ' is not a word.');

    return possible_word


# End of core functions ------------------------------------------------------


#http://stackoverflow.com/questions/287871/print-in-terminal-with-colors-using-python
class bcolors:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'

    def disable(self):
        self.HEADER = ''
        self.OKBLUE = ''
        self.OKGREEN = ''
        self.WARNING = ''
        self.FAIL = ''
        self.ENDC = ''


def help_and_exit():
    print 'usage: python possible_wordcheck.py <input> (uses the default bigram file)'
    print '       python possible_wordcheck.py <file with bigram data> -f <input_file>'
    print '       python possible_wordcheck.py <file with bigram data> -i <input>'
    sys.exit(1)


if __name__ == '__main__':
    # Use the default bigram file to check the first arg for word
    # Just prints whether it's a word or not, and nothing else
    if len(sys.argv)==2:
        print is_possible_word(sys.argv[1]);
        sys.exit(0)

    if len(sys.argv)!=4: help_and_exit()

    # Use stdout to log here
    logging.basicConfig(format="%(message)s", 
                    stream=sys.stdout, level=logging.DEBUG)
    stdout_logger = logging.getLogger(__name__)

    bigram_file=sys.argv[1]

    if sys.argv[2]=='-f':
        input_file=sys.argv[3]
        lines = [line.rstrip('\n') for line in open(input_file)]
        for line in lines:
            print is_possible_word(line, bigram_file, logger=stdout_logger, colors=True), '\n'
            #print is_possible_word(line, bigram_file, logger=stdout_logger, colors=False), '\n'

    elif sys.argv[2]=='-i':
        input_str = sys.argv[3]
        print is_possible_word(input_str, bigram_file, logger=stdout_logger, colors=True)

    else: help_and_exit()
