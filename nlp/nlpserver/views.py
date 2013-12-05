#!/usr/bin/env python

from nlpserver import app
from flask import request, jsonify

# for cross-site http requests
from flask import make_response, request, current_app
from datetime import timedelta
from functools import update_wrapper

# nlp core
from scripts.possible_wordcheck.possible_wordcheck import is_possible_word
from scripts.wordcheck.wordcheck import is_word, is_word_ignorecase, get_suggestions

#=============================================================================

# Decorator for the HTTP Access Control, via http://flask.pocoo.org/snippets/56/
def crossdomain(origin=None, methods=None, headers=None,
                max_age=21600, attach_to_all=True,
                automatic_options=True):
    if methods is not None:
        methods = ', '.join(sorted(x.upper() for x in methods))
    if headers is not None and not isinstance(headers, basestring):
        headers = ', '.join(x.upper() for x in headers)
    if not isinstance(origin, basestring):
        origin = ', '.join(origin)
    if isinstance(max_age, timedelta):
        max_age = max_age.total_seconds()

    def get_methods():
        if methods is not None:
            return methods

        options_resp = current_app.make_default_options_response()
        return options_resp.headers['allow']

    def decorator(f):
        def wrapped_function(*args, **kwargs):
            if automatic_options and request.method == 'OPTIONS':
                resp = current_app.make_default_options_response()
            else:
                resp = make_response(f(*args, **kwargs))
            if not attach_to_all and request.method != 'OPTIONS':
                return resp

            h = resp.headers

            h['Access-Control-Allow-Origin'] = origin
            h['Access-Control-Allow-Methods'] = get_methods()
            h['Access-Control-Max-Age'] = str(max_age)
            if headers is not None:
                h['Access-Control-Allow-Headers'] = headers
            return resp

        f.provide_automatic_options = False
        return update_wrapper(wrapped_function, f)
    return decorator

# generalised function for the views below
# flip determines whether to flip the boolean result returned from the view_action
def view_helper(view_action, flip=False):
    input = request.args.get("input", '')
    if input:
        if flip:
            return jsonify( response = not view_action(input) )
        else:
            return jsonify( response = view_action(input) )
    else:
        return jsonify ( response = "input required" )

#=============================================================================

@app.route("/")
def hello():
    app.logger.info("swagatam");
    return "NLP API: Swagatam"


# When word is deemed not possible, run it through the other checker...
# This will accept loan words like Qatar (as long as they are in a
# dictionary)
@app.route("/possible_wordcheck", methods=['GET'])
@crossdomain(origin=app.config['ALLOWED_DOMAINS'])
def possible_wordcheck():
    def double_wordcheck(input):
        if is_possible_word(input, logger=app.logger):
            return True
        else:
            second_check = is_word_ignorecase(input)
            app.logger.info("Result of second word check for %s: %s", 
                            input, second_check)
            return second_check
    return view_helper(double_wordcheck)


# The idea for this is to forbid loan words like Qatar
@app.route("/possible_wordcheck_strict", methods=['GET'])
@crossdomain(origin=app.config['ALLOWED_DOMAINS'])
def possible_wordcheck_strict():
    return view_helper(is_possible_word)


# checks if it's a borrowed word. same as possible_wordcheck_strict, 
# with just different phrasing, and polarity reversed
@app.route("/borrowcheck", methods=['GET'])
@crossdomain(origin=app.config['ALLOWED_DOMAINS'])
def borrowcheck():
    return view_helper(is_possible_word, flip=True)


# just a dictionary check 
@app.route("/wordcheck", methods=['GET'])
@crossdomain(origin=app.config['ALLOWED_DOMAINS'])
def wordcheck():
    return view_helper(is_word_ignorecase)


# like above but takes case into account, so this becomes a spell check
@app.route("/spellcheck", methods=['GET'])
@crossdomain(origin=app.config['ALLOWED_DOMAINS'])
def spellcheck():
    return view_helper(is_word)


# Word suggestions for input
@app.route("/spell_suggestions", methods=['GET'])
@crossdomain(origin=app.config['ALLOWED_DOMAINS'])
def spell_suggestions():
    return view_helper(get_suggestions)
