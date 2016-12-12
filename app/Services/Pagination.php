<?php namespace App\Services;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Pagination
{

  /**
   * Create paginator
   *
   * @param  Illuminate\Support\Collection  $collection
   * @param  int     $total
   * @param  int     $perPage
   * @return string
   */
  public static function makeLengthAware($collection, $total, $perPage)
  {
    $paginator = new LengthAwarePaginator(
      $collection, 
      $total, 
      $perPage, 
      Paginator::resolveCurrentPage(), 
      ['path' => Paginator::resolveCurrentPath()]);

    return str_replace('/?', '?', $paginator->render());
  }

}

