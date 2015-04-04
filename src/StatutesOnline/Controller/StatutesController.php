<?php

namespace StatutesOnline\Controller;

use Silex\Application;
use Michelf\Markdown;
use StatutesOnline\Html\Toc;

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

    $language = $app['request']->get('language');

    $md = file_get_contents("assets/statutes/{$language}.md");
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

    $tocGenerator = new Toc;

    $body =  str_replace('[TOC]', '', $parser->transform($md) );

    $generated = $tocGenerator->generateToc( $body );

    $html = $generated['html'];
    $toc = $generated['toc'];

    $title = $language == 'nl_be' ? 'Statuten van Piratenpartij' : 'Statuts du Parti Pirate';

    return $app['twig']->render('statutes/statutes.html.twig', array(
      'body' => $body,
      'menu' => '',
      'title' => $title
    ));
  }
}
