#!/usr/bin/env python

import sys
import enchant

#d = enchant.Dict("en_US")
d = enchant.DictWithPWL("en_US", "mywords.txt")


def get_suggestions(input_str):
    return d.suggest(input_str)

def is_word(input_str):
    return d.check(input_str)

# For our purposes here, Qatar and qatar should be both accepted.
# pyenchant does not seem to provide an option to ignore case
# So I resort to this.
def is_word_ignorecase(input_str):
    suggestions = d.suggest(input_str) 
    if input_str.lower() == suggestions[0].lower():
        return True
    else:
        return d.check(input_str)

def help_and_exit():
    print 'usage: python wordcheck.py <input>'
    print '       python wordcheck.py -i <input>' # ignores case
    print '       python wordcheck.py -s <input>' # for spelling suggestions
    sys.exit(1)

if __name__ == '__main__':
    if len(sys.argv)==2:
        print is_word(sys.argv[1]);
        sys.exit(0)

    if len(sys.argv)!=3: help_and_exit()

    if sys.argv[1]=='-i':
        print is_word_ignorecase(sys.argv[2])

    elif sys.argv[1]=='-s':
        print get_suggestions(sys.argv[2])

    else: help_and_exit()
