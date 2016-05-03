# Anekdotes Meta

[![Latest Stable Version](https://poser.pugx.org/anekdotes/meta/v/stable)](https://packagist.org/packages/anekdotes/meta)
[![Build Status](https://travis-ci.org/anekdotes/meta.svg)](https://travis-ci.org/anekdotes/meta)
[![codecov.io](https://codecov.io/gh/anekdotes/meta/branch/master/graph/badge.svg)](https://codecov.io/github/anekdotes/meta?branch=master)
[![StyleCI](https://styleci.io/repos/57909394/shield?style=flat)](https://styleci.io/repos/57909394)
[![License](https://poser.pugx.org/anekdotes/meta/license)](https://packagist.org/packages/anekdotes/meta)
[![Total Downloads](https://poser.pugx.org/anekdotes/meta/downloads)](https://packagist.org/packages/anekdotes/meta)

Contains utility classes meant to reference themselves and manipulate events/storage

## Installation

Install via composer into your project:

    composer require anekdotes/meta

## Basic Usage

Call the namespace of the object you want to use and use its functions. There are many utilities classes to choose from, described below:

## Registry

A data storage class. Meant to be extended and to load arrays in dot notation.

    use Anekdotes\Meta\Registry
    $registry = new Registry();
    $registry->load(["toaster.test" => "Test","toaster.toast" => "Toast","testing.test" => "Tested"]);
    $registry->get("testing.test"); //Returns "Tested"
    $registry->group("toaster"); //Returns ["test" => "Test","toast" = "Toast"]
    $registry->has("testing.test"); //Checks if key exists. Returns true.

Additional functions to manipulate registries can be found in the source code

## StaticRegistry

The StaticRegistry is a Singleton instance of the Registry.

    use Anekdotes\Meta\StaticRegistry
    StaticRegistry::load(["toaster.test" => "Test"]);

## Config

A file loader that fills a registry based on the file content.

    use Anekdotes\Meta\Config
    $config = new Config();
    $path = "app/config/config.php";
    $config->loadFile($path);

It can also load folder of config files.

    $config = new Config();
    $path = "app/config";
    $config->loadFolder($path);

Files must use the following format :

    <?php

    return array(
        'dummy' => 'dummy.php',
        'test' => 'test.php',
    );

Since Config extends Registry, you can obtain the content as with a registry.

    $config->get("dummy"); //Returns "dummy.php"

Loading files can also be prefixed with the filename and have an additonal namespace as prefix

    $config = new Config();
    $path = "app/config/config.php";
    $prefix = true;
    $namespace = "Meta";
    $config->loadFile($path,$prefix,$namespace);
    $config->all(); //This will return ["Meta::config.dummy" => "dummy.php","Meta::config.test","test.php"];

## Dispatcher

The Dispatcher allows an observer design pattern usage. It simply stores listener functions that gets fired when their action is called.

    use Anekdotes\Meta\Dispatcher;
    $functionThatWillGetFired = function(){
        echo "Hello world!";
    }
    $otherFunctionThatWillBeFired = function(){
        echo "I am fabulous.";
    }
    $dispatcher = new Dispatcher();
    $dispatcher->listen('call',$functionThatWillGetFired);
    $dispatcher->listen('call',$otherFunctionThatWillBeFired);
    $dispatcher->fire('call'); //Will echo both "Hello world" and "I am fabulous"
    $dispatcher->flush('call'); //Removes all listeners associated to the event "call"

## ObjectArrayActionDispatcher

The Object Array Action Dispatcher is a different kind of action dispatcher. It treats an array of objects having different actions to be called.

    use Anekdotes\Meta\ObjectArrayActionDispatcher;
    $FirstFunctionToGetFired = function($RandomParam){
        echo "Hello " . $RandomParam ;
    }
    $SecondFunctionToBeFired = function($RandomParam){
        echo "Test " . $RandomParam ;
    }
    $dispatcher = new ObjectArrayActionDispatcher(["ActionOne" => ["call" => $FirstFunctionToGetFired], "ActionTwo" => ["call" => $SecondFunctionToGetFired]]);
    $dispatcher->call("Math"); //Will echo "Hello Math" and "Test Math"
