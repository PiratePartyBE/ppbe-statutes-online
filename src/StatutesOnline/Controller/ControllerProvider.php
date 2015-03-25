<?php

namespace StatutesOnline\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;

use StatutesOnline\Controller\IndexController;

/**
 * Implements the ControllerProviderInterface and .
 */
class ControllerProvider implements ControllerProviderInterface, ServiceProviderInterface {

  /**
   * @param  Silex\Application $app [description]
   * @see Silex\ServiceProviderInterface
   */
  public function boot( Application $app ) {

  }

  /**
   * @param  Silex\Application $app
   * @see Silex\ServiceProviderInterface
   */
  public function register( Application $app ) {

    $app['statutes.controller'] = $app->share(function() {
        return new StatutesController();
    });
  }

  /**
   * @param  Silex\Application $app
   * @see Silex\ControllerProviderInterface
   */
  public function connect(Application $app) {

    $controllers = $app['controllers_factory'];

    $controllers->get('/', "statutes.controller:index");

    return $controllers;
  }
}
