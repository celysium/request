<?php
namespace Celysium\Request\Facades;

use Closure;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Facade;

/**
 * @method static PendingRequest request($to = null)
 * @method static array batch(Closure $callback)
 * @method static PendingRequest async(Pool $pool, string $key)
 */
class RequestBuilder extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'request-builder';
    }
}
