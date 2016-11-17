# Anekdotes Meta

[![Latest Stable Version](https://poser.pugx.org/anekdotes/meta/v/stable)](https://packagist.org/packages/anekdotes/meta)
[![Build Status](https://travis-ci.org/anekdotes/meta.svg)](https://travis-ci.org/anekdotes/meta)
[![codecov.io](https://codecov.io/github/anekdotes/meta/coverage.svg?branch=master)](https://codecov.io/github/anekdotes/meta?branch=master)
[![StyleCI](https://styleci.io/repos/57909394/shield?style=flat)](https://styleci.io/repos/57909394)
[![License](https://poser.pugx.org/anekdotes/meta/license)](https://packagist.org/packages/anekdotes/meta)
[![Total Downloads](https://poser.pugx.org/anekdotes/meta/downloads)](https://packagist.org/packages/anekdotes/meta)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/18e8376a738c4f2c8043bfb9bda57d90)](https://www.codacy.com/app/steve-gagnev4si/meta?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=anekdotes/meta&amp;utm_campaign=Badge_Grade)

Contains utility classes meant to reference themselves and manipulate events/storage

## Installation

Install via composer into your project:

    composer require anekdotes/meta

## Basic Usage

Call the namespace of the object you want to use and use its functions. There are many utilities classes to choose from, described below:

## Registry

A data storage class. Meant to be extended and to load arrays in dot notation.

```php
use Anekdotes\Meta\Registry
$registry = new Registry();
$registry->load(["toaster.test" => "Test","toaster.toast" => "Toast","testing.test" => "Tested"]);
$registry->get("testing.test"); //Returns "Tested"
$registry->group("toaster"); //Returns ["test" => "Test","toast" = "Toast"]
$registry->has("testing.test"); //Checks if key exists. Returns true.
```

Additional functions to manipulate registries can be found in the source code

## StaticRegistry

The StaticRegistry is a Singleton instance of the Registry.

```php
use Anekdotes\Meta\StaticRegistry
StaticRegistry::load(["toaster.test" => "Test"]);
```

## Config

A file loader that fills a registry based on the file content.

```php
use Anekdotes\Meta\Config
$config = new Config();
$path = "app/config/config.php";
$config->loadFile($path);
```

It can also load folder of config files.

```php
$config = new Config();
$path = "app/config";
$config->loadFolder($path);
```

Files must use the following format :

```php
<?php

return array(
    'dummy' => 'dummy.php',
    'test' => 'test.php',
);
```

Since Config extends Registry, you can obtain the content as with a registry.

```php
$config->get("dummy"); //Returns "dummy.php"
```

Loading files can also be prefixed with the filename and have an additonal namespace as prefix

```php
$config = new Config();
$path = "app/config/config.php";
$prefix = true;
$namespace = "Meta";
$config->loadFile($path,$prefix,$namespace);
$config->all(); //This will return ["Meta::config.dummy" => "dummy.php","Meta::config.test","test.php"];
```

## Dispatcher

The Dispatcher allows an observer design pattern usage. It simply stores listener functions that gets fired when their action is called.

```php
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
```

## ObjectArrayActionDispatcher

The Object Array Action Dispatcher (OAAD) is a different kind of action dispatcher. It treats an array of objects having different actions to be called.

To use, simply : 
1 - create the OAAD with the objects that have a function with the same signature to be called
2 - Call the function on the dispatcher

The following examples demonstrates calling set on multiples registries using an OOAD.

```php
use Anekdotes\Meta\ObjectArrayActionDispatcher;
$registry1 = new Registry();
$registry1->load(['Test' => 'Tests','Toast' => 'Toasts']);  
$registry2 = new Registry();
$registry2->load(['Test' => 'Nope','Toast' => 'Nope']);
$dispatcher = new ObjectArrayActionDispatcher([$registry1,$registry2]);
$dispatcher->set('Test','SuperTest'); //This calls the function SET on both registry objects, passing the parameters "Test" and "SuperTest."
$registry1->all(); //Now returns ['Test' => 'SuperTest', 'Toast' => 'Toasts']
$registry2->all(); //Now returns ['Test' => 'SuperTest', 'Toast' => 'Nope']
```
