# How to create my first module into Sample-App

## Initialize the module

Create the module into Sample-App:

    mkdir modules/helloworld

Then, initialize the structure of this new module:

    cd modules/helloworld
    mkdir ./classes ./views ./i18n ./assets

Now create the backbone router:

    mkdir -p ./assets/app/module/helloworld

Create the file `./assets/app/module/helloworld/router.js`:

    define([
	'backbone',
	'marionette'
    ], function(Backbone, Marionette)
    {
        var myRouter = Marionette.AppRouter.extend(
        {
                initialize: function(options)
                {
                        console.log('Hello World !');
                }
        });

        return myRouter;
    });

Now, create the file `init.php` at the root directory of the module by coping the following line:

    // Set javascript module to be load at initialization
    Service::factory('Application')->set_js_init('module/helloworld/router');

##Activate the module

Go back to the root directory of Sample-App.

Configuration files are into `application/config/` directory.

    cd application/config
    cp app.local.php-sample app.local.php

This file should contain a `module` key like the following:

    <?php defined('SYSPATH') or die('No direct script access.');

    /**
     * Define your local settings here.
     * They will not be overriden by software update.
     */
    $local = array(

        // This is application module that should be loaded at initialization
        'module' => array(

                // Load module that need routing
                'assets' => dirname(APPPATH).'/vendor/kohana-assets',

                // Load your hello world module
                'helloworld' => dirname(APPPATH).'/modules/helloworld',

                // Load the sampleapp module
                'sampleapp' => dirname(APPPATH).'/modules/sampleapp',

                // Finaly load additionnal module that do not need routing
                'browser' => dirname(APPPATH).'/vendor/kohana-browser',
                'email' => dirname(APPPATH).'/vendor/kohana-email',
                'mongodb' => dirname(APPPATH).'/vendor/kohana-mongodb',
                'password' => dirname(APPPATH).'/vendor/kohana-password',
                'restful' => dirname(APPPATH).'/vendor/kohana-restful',
                'twig' => dirname(APPPATH).'/vendor/kohana-twig',
        ),

    );

Note that the `module` key have to redeclare all modules!

## Verify that the module is loaded

Go to the application, open the web console, and verify that the message 'Hello World !'
is correctly displayed.

