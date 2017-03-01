<?php 
namespace Beaplat\Swal\Facades;

use Illuminate\Support\Facades\Facade;

class Swal extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'swal';
    }
}