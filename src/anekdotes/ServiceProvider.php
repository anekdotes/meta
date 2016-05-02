<?php

/*
 * This file is part of the Meta package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Meta;

/**
 * Service Providers are used to create services that are then registered for use in the Application. This allows instantiation of the service, registration of app listeners used by the service and creation a shortcut for the service in the app.
 */
abstract class ServiceProvider {

  /**
   * Register the service in the application
   * @param  \Sitebase\Application\Application  $app  The Application that will use the service
   */
  abstract public function register($app);

}
