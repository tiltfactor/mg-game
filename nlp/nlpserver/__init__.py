#!/usr/bin/env python

from flask import Flask
#from flask_sslify import SSLify
import logging

app = Flask(__name__)
#sslify = SSLify(app)

app.config.from_pyfile('../config.py')
#app.config.from_envvar('NLPSERVER_CONFIG')

# Configure file logging
#if not app.debug:
file_handler = logging.FileHandler(app.config['LOG_FILE'])
file_handler.setFormatter(app.config['DEFAULT_LOG_FORMATTER'])
#file_handler.setLevel(app.config['DEFAULT_LOG_LEVEL'])
app.logger.addHandler(file_handler)

from nlpserver import views
