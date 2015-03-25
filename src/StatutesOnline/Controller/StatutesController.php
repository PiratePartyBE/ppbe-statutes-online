<?php

namespace StatutesOnline\Controller;

use Silex\Application;
use Michelf\Markdown;

/**
 * Index controller
 * @package claroline-core
 */
class StatutesController {

  protected $app;

  /**
   * Serve the index page
   * @param  Silex\Application $app
   * @return page output
   */
  public function index(Application $app) {
    return $app['twig']->render('statutes/index.html.twig');
  }

  /**
   * Serve the index page
   * @param  Silex\Application $app
   * @return page output
   */
  public function statutes(Application $app) {
    // get lang from request
    $language = $app['request']->get('language');
    // load markdown file

    if ( $language === 'fr_be' || $language === 'nl_be' ) {

      $md = file_get_contents("https://raw.githubusercontent.com/zefredz/ppbe-statutes-test/master/ppbe-statutes-{$language}.md");
      // parse markdown
      $parser = new Markdown;
      // rewrite internal url
      $parser->url_filter_func = function ($url) {
        if ( strpos( $url, 'http' ) === 0 ) {
          return $url;
        }
        else {
          return "/$url";
        }
      };
      $html = $parser->transform($md);
      $html = str_replace('[TOC]', '<div class="toc"></div>', $html);
      // display statutes
      return $app['twig']->render('statutes/statutes.html.twig', array('body' => $html));
    }
    else {
      throw new Exception("Ressource not found!");
    }
  }
}
