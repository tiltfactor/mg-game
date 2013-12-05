#!/usr/bin/env python

from __future__ import division
import string, sys
import random 
import json
#from pprint import pprint # pretty print, for dictionaries


def process_file(file):
    text = open(file).read().lower()  
    text = filter(lambda x:x in string.lowercase or x in string.whitespace, text)  #only retain [a-z] and space
    return text


# Normalize each conditional probability..
def normalize_ngram(ngram):
    for context in ngram:
        total = sum(ngram[context].values())
        for word in ngram[context]:
            ngram[context][word]/=total


def bigram_letters(file):
    text = process_file(file)

    bigram = {}

    for i, letter in enumerate(text):  #need to keep track of the position
        if i==0:  #no context
            #context = '#'
            context = ' '
        else:
            context = text[i-1]  #previous letter
        if context not in bigram: 
            bigram[context]={}
            bigram[context][letter]=1
        elif letter not in bigram[context]:
            bigram[context][letter]=1
        else:
            bigram[context][letter]+=1
            
    normalize_ngram(bigram)

    return bigram

# TODO: Integrate n-gram generation...
#def trigram_letters(file):
    #text = process_file(file)

    #trigram = {}

    #for i, letter in enumerate(text):  #need to keep track of the position
        #if i==0:  #no context
            ##context = '#'
            #context = ' '
        #elif i==1:  #single letter as context
            #context = text[i-1]
        #else:
            #context = text[i-2] + text[i-1] #previous 2 letters
        
        #if context not in trigram:
            #trigram[context]={}
            #trigram[context][letter]=1
        #elif letter not in trigram[context]:
            #trigram[context][letter]=1
        #else:
            #trigram[context][letter]+=1

    #normalize_ngram(trigram)

    #return trigram


# Test functions -------------------------------------------------------------

def sample_distribution(coin):
    val = random.random()  #pick a random num between 0 and 1
    for outcome in coin:  #iterate though outcomes (keys)
        if val<coin[outcome]:
            return outcome #winner!
        else:
            val-=coin[outcome]  #re-adjust scale
    return None


# testing the generated bigram. Output random string of length outputlen
def generate_bigrams(outputlen, bigramdist):
    output=''
    for i in range(outputlen):
        if i==0:
            #output+=sample_distribution(bigramdist['#'])
            output+=sample_distribution(bigramdist[' '])
        else:
            output+=sample_distribution(bigramdist[output[i-1]])
    return output

# End of test functions -------------------------------------------------------------


if __name__ == '__main__':
    if len(sys.argv)!=3:
       print 'usage: python generate_bigram_data.py <file with corpus> <file to save data>'
       sys.exit(1)

    training_bigram = bigram_letters(sys.argv[1])
    #pprint(training_bigram)
    #training_trigram = trigram_letters(sys.argv[1])
    #pprint(training_trigram)

    # save the generated bigram in a file
    with open(sys.argv[2], 'w') as f:
        json.dump(training_bigram, f)
        #json.dump(training_trigram, f)

    # testing the bigram
    print 'Random text based on the bigram'
    print ''
    print generate_bigrams(500, training_bigram)
