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

    $app['main.controller'] = $app->share(function() {
        return new IndexController();
    });

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

    $controllers->get('/', "main.controller:index");

    $controllers->get('/statutes', "statutes.controller:index");

    $controllers->get('/statutes/{language}', "statutes.controller:statutes");

    return $controllers;
  }
}
