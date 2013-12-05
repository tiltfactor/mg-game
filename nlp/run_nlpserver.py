#!/usr/bin/env python

from nlpserver import app

#app.run();

# with SERVER_NAME, views failed, so new SERVERNAME key is setup in the config
#app.run(app.config['SERVER_NAME'], app.config['SERVER_PORT']) 
app.run(app.config['SERVERNAME'], app.config['SERVER_PORT'])
