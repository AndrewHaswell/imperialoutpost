<?php

namespace App\Http\Controllers;

use \DOMDocument;
use \DOMXPath;

class ComicController extends Controller
{

  public function index()
  {
    $this->dilbert();
    $this->pvp();
    $this->penny_arcade();
  }

  /**
   * Get the last few Dilbert strips
   *
   * @author Andrew Haswell
   */

  public function dilbert()
  {
    echo '<h3>Dilbert</h3>';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://dilbert.com/");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);

    curl_close($ch);

    $dom = new DOMDocument();

    libxml_use_internal_errors(true);
    $dom->loadHTML($data);
    libxml_use_internal_errors(false);

    $xpath = new DOMXPath($dom);
    $elements = $xpath->query('//img[contains(@class,"img-comic")]/@src');

    $strips = [];

    foreach ($elements as $strip) {
      $strips[] = $strip->value;
      echo '<img width="700px" src="' . (string)$strip->value . '" /><br/><br/>';
    }
  }

  /**
   * @author Andrew Haswell
   */

  public function penny_arcade()
  {
    echo '<h3>Penny Arcade</h3>';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.penny-arcade.com/comic");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);

    curl_close($ch);

    $dom = new DOMDocument();

    libxml_use_internal_errors(true);
    $dom->loadHTML($data);
    libxml_use_internal_errors(false);

    $xpath = new DOMXPath($dom);
    $elements = $xpath->query('//div[@id="comicFrame"]/a/img/@src');

    $strips = [];

    foreach ($elements as $strip) {
      $strips[] = $strip->value;
      echo '<img width="700px" src="' . (string)$strip->value . '" /><br/><br/>';
    }
  }

  /**
   * @author Andrew Haswell
   */

  public function pvp()
  {
    echo '<h3>PvP</h3>';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://pvponline.com/comic");
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
    $elements = $xpath->query('//section[@class="comic-art"]/img/@src');

    $strips = [];

    foreach ($elements as $strip) {
      $strips[] = $strip->value;
      echo '<img width="700px" src="' . (string)$strip->value . '" /><br/><br/>';
    }
  }
}
