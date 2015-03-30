<?php

namespace StatutesOnline\Html;

/**
 * @link https://github.com/mattfarina/markdown-extra/blob/master/src/mattfarina/MarkdownExtra/Toc.php
 */
class Toc {

  /**
   * Generate a clickable Html TOC for the given Html
   * @param string $html
   *        Html for which the TOC must be generated.
   * @return array (
   *         toc => TOC,
   *         html => modified Html ).
   */
  public function generateToc( $html, $type = 'ul' ) {

    $document = \QueryPath::withHTML($this->prepareHtml($html));

    // The toc being generated.
    $toc = '';
    $curr = $last = 0;

    // Build the TOC
    $cmd = $this;

    $document->xpath('//h1|//h2|//h3|//h4|//h5|//h6')->each(function($index, $item) use (&$toc, $cmd, &$curr, &$last, $type) {
      // Put the header level into $curr (e.g., 1, 2, 3...)
      sscanf($item->tagName, 'h%u', $level);

      $qpitem = \QueryPath::with($item);
      // Get and/or set an id
      if ($item->hasAttribute('id')) {
        $id = $item->getAttribute('id');
      }
      else {
        $id = $cmd->safeId($qpitem->text());
        $item->setAttribute('id', $id);
        // $qpitem->setAttribute('id', $id);
      }

      $toc .= '<li class="toc-h'.$level.'"><a href="#' . $id . '" data-smoothscroller2="data-smoothscroller2">' . $qpitem->innerHTML() . "</a></li>\n";
    });

    $toc .='</' . $type . '>';

    return array(
      'toc' => $toc,
      'html' => $document->top('body')->innerHTML()
    );
  }

  /**
   * Create a HTML stuf document from a block of markup text.
   *
   * @param  string $text
   *   A block of html text that would normally reside inside the body of a
   *   document.
   * @return string
   *   The text wrapped in an html document that makes it easier for the parser
   *   to work with.
   */
  protected function prepareHtml($text) {
    return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>' . $text . '</body></html>';
  }

  /**
   * Generate a safe html id to insert into markup.
   *
   * Not all characters are allowed in markup. This takes some text and converts
   * it into a safe and usable html id.
   *
   * @param  string $text
   *   The string of text to convert into a html id.
   *
   * @return string
   *   A valid html id.
   */
  public function safeId($text) {
    // Lowercase the string and convert a few characters.
    $id = strtr(strtolower($text), array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
    // Remove invalid id characters.
    $id = preg_replace('/[^A-Za-z0-9\-_]/', '', $id);
    return $id;
  }
}
