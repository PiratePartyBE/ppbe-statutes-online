<?php

namespace StatutesOnline\Controller;

use Silex\Application;

/**
 * Index controller
 * @package claroline-core
 */
class IndexController {

  protected $app;

  /**
   * Serve the index page
   * @param  Silex\Application $app
   * @return page output
   */
  public function index(Application $app) {
    return $app['twig']->render('index.html.twig');
  }
}
