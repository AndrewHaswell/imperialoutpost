<?php

namespace App\Http\Controllers;

use App\ComicStrip;

use \DOMDocument;
use \DOMXPath;

class ComicController extends Controller
{

  public function index()
  {
    $comics_strip_model = new ComicStrip();
    $strips = $comics_strip_model->get_all_strips();
    foreach ($strips as $strip) {
      $this->get_strip((string)$strip->title, (string)$strip->url, (string)$strip->xpath_query);
    }
    $this->get_strip('PvP Online','http://pvponline.com/comic', '//section[@class="comic-art"]/img/@src');
    exit;
    /**
     * $this->get_strip('http://dilbert.com/', '//img[@class="img-comic"]/@src');
     * $this->get_strip('http://www.penny-arcade.com/comic', '//div[@id="comicFrame"]/a/img/@src');
     * $this->get_strip('http://pvponline.com/comic', '//section[@class="comic-art"]/img/@src');
     * $this->get_strip('http://www.sheldoncomics.com/', '//img[@id="strip"]/@src');
     */
  }

  /**
   * @param string $title
   * @param string $url
   * @param string $xpath_query
   * @return bool
   * @author Andrew Haswell
   */

  public function get_strip($title = '', $url = '', $xpath_query = '')
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);

    $curl_info = curl_getinfo($ch);
    if ($curl_info['http_code'] != 200) {
      return false;
    }

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
