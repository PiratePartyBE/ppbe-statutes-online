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

    $lang = array('nl_be','fr_be');
    $html = array();

    foreach ( $lang as $language ) {

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

      $html[$language] = str_replace('[TOC]', '<div class="toc_'.$language.'"></div>', $parser->transform($md) );
    }

    return $app['twig']->render('statutes/index.html.twig', array(
      'body_nl_be' => $html['nl_be'],
      'body_fr_be' => $html['fr_be'],
    ));
  }
}
