<?php

namespace Celysium\Request;

use Closure;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Celysium\Authenticate\Facades\Authenticate;

class RequestBuilder
{
    /**
     * Call request http.
     * @return mixed
     */
    public function request(): mixed
    {
        return $this->configuration(new Http());
    }

    /**
     * @param Closure $callback
     * @return mixed
     */
    public function batch(Closure $callback): mixed
    {
        return Http::pool(function(Pool $pool) use ($callback) {
            return $callback($pool);
        });
    }

    /**
     * Add a request to the batch with a key.
     * @param Pool $pool
     * @param string|null $key
     * @return PendingRequest
     */
    public function async(Pool $pool, string $key = null): PendingRequest
    {
        if ($key) {
            $pool = $pool->as($key);
        }
        return $this->configuration($pool);
    }

    public function configuration(mixed $request): mixed
    {
        return $request
            ->baseUrl(env('HUB_BASE_URL'))
            ->acceptJson()
            ->withHeaders(['microservice' => env('MICROSERVICE_SLUG', 'none')])
            ->withHeaders(Authenticate::headers());
    }
}