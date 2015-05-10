<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicStrip extends Model
{

  /**
   * @return mixed
   * @author Andrew Haswell
   */

  public function get_all_strips()
  {
    $strips = ComicStrip::where('active', '=', 'Y')->get();
    return $strips;
  }
}
