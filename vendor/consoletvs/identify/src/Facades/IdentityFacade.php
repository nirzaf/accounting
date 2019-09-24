<?php

namespace Unicodeveloper\Identify\Facades;

use Illuminate\Support\Facades\Facade;

class IdentityFacade extends Facade
{
    /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
      return 'laravel-identify';
  }
}
