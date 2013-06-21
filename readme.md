This is Sample-App
==================

Overview
--------

This is a demo application using Kohana 3.3+ with REST, MongoDB, Backbone.js and Marionette.js.
My goal is to learn how to use Marionette.js and MongoDB with a REST backend based on Kohana 3.3.

Requirements
------------

This application needs the following dependencies:

  *   PHP 5.3
  *   A HTTP server (like Apache or Lighttpd)
  *   MongoDB


Quick installation notes
------------------------

On the system:

    # mkdir ./data/cache ./data/log
    # chown www-data:www-data ./data/cache ./data/log

This is a example of Lighttpd configuration:

    $HTTP["host"] =~ "^example\.com$" {
        server.document-root = "/var/www/example.com/www/"
        server.name = "example.com"
        accesslog.filename = "/var/log/lighttpd/example.com.access.log"
        alias.url = (
                "/sample-app/assets/" => "/var/www/example.com/www/sample-app/data/cache/assets/",
                "/sample-app/" => "/var/www/example.com/www/sample-app/public/"
        )
        url.rewrite-if-not-file  = (
                "^/sample-app/(.+)" => "/sample-app/index.php/$1"
        )
        setenv.add-environment = (
                "KOHANA_ENV" => "production"
        )
    }

