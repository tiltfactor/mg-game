#!/usr/bin/env python

import logging, os

# Flask app debug value. 
#DEBUG = False # DEBUG AND INFO log levels won't be shown..
DEBUG = True 

# Used for running the flask server independent of mod_wsgi
# using SERVER_NAME as the var name makes views fail..
#SERVERNAME = "127.0.0.1"
SERVERNAME = "localhost" 
SERVER_PORT = 8139
#SERVER_PORT = 5000

# URLs from which request (ajax) can be made to this server
ALLOWED_DOMAINS = "*"                   # all
#ALLOWED_DOMAINS = "http://"+SERVERNAME # allow calls from elsewhere in the same server

#PREFERRED_URL_SCHEME='https'

# Get the current dir for the application
APPLICATION_PATH = os.path.dirname(os.path.realpath(__file__))

# If mod_wsgi is used, messages will also get logged to the apache log files 
LOG_FILE = os.path.join(APPLICATION_PATH, "nlpserver.log") 
DEFAULT_LOG_FORMATTER = logging.Formatter(\
   "%(asctime)s - %(levelname)s - %(message)s")

# these not really needed since DEBUG_VAL above influences this
#DEFAULT_LOG_LEVEL = logging.DEBUG 
#DEFAULT_LOG_LEVEL = logging.WARNING
