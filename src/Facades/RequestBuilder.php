<?php
namespace Celysium\Request\Facades;

use Closure;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed request()
 * @method static mixed batch(Closure $callback)
 * @method static mixed async(Pool $pool, string $key)
 */
class RequestBuilder extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'request-builder';
    }
}
