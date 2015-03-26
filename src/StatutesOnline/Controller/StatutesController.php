<?php

namespace StatutesOnline\Controller;
use Symfony\Component\HttpFoundation\Response;

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

    $respHtml = $app['twig']->render('statutes/index.html.twig');

    return new Response($respHtml, 200, array(
        'Cache-Control' => 's-maxage=5',
    ));
  }

  /**
   * Serve the index page
   * @param  Silex\Application $app
   * @return page output
   */
  public function statutes(Application $app) {

    $language = $app['request']->get('language');

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

    $html = str_replace('[TOC]', '<div class="toc"></div>', $parser->transform($md) );

    $respHtml = $app['twig']->render('statutes/statutes.html.twig', array(
      'body' => $html
    ));

    return new Response($respHtml, 200, array(
        'Cache-Control' => 's-maxage=5',
    ));
  }
}
