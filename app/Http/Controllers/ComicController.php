<?php

namespace App\Http\Controllers;

use \DOMDocument;
use \DOMXPath;

class ComicController extends Controller
{

  public function index()
  {
    $this->get_strip('http://dilbert.com/', '//img[contains(@class,"img-comic")]/@src');
    $this->get_strip('http://www.penny-arcade.com/comic', '//div[@id="comicFrame"]/a/img/@src');
    $this->get_strip('http://pvponline.com/comic', '//section[@class="comic-art"]/img/@src');
    $this->get_strip('https://garfield.com/', '//a[@id="home_comic"]/img/@src');
    $this->get_strip('http://www.sheldoncomics.com/', '//img[@id="strip"]/@src');
  }

  /**
   * @param string $url
   * @param string $xpath_query
   * @author Andrew Haswell
   */

  public function get_strip($url = '', $xpath_query = '')
  {
    echo '<h3>' . parse_url($url, PHP_URL_HOST) . '</h3>';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);

    curl_close($ch);

    $dom = new DOMDocument();

    libxml_use_internal_errors(true);
    $dom->loadHTML($data);
    libxml_use_internal_errors(false);

    $xpath = new DOMXPath($dom);
    $elements = $xpath->query($xpath_query);

    $strips = [];

    foreach ($elements as $strip) {
      $strips[] = $strip->value;
      echo '<img width="700px" src="' . (string)$strip->value . '" /><br/><br/>';
    }
  }
}
