<?php

namespace Celysium\Request;

use Closure;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Celysium\Authenticate\Facades\Authenticate;
use Exception;

class RequestBuilder
{
    /**
     * Call request http.
     * @param string|null $to
     * @return mixed
     * @throws Exception
     */
    public function request(string $to = null): PendingRequest
    {
        $baseUrl = $to === 'api_gateway' ? env('AG_BASE_URL') : env('HUB_BASE_URL');
        if(is_null($baseUrl)) {
            throw new Exception('base url not set in env');
        }
        return $this->configuration(Http::BaseUrl($baseUrl));
    }

    /**
     * @param Closure $callback
     * @return mixed
     */
    public function batch(Closure $callback): array
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

    public function configuration(PendingRequest|Http|Pool $request): PendingRequest
    {
        return $request
            ->acceptJson()
            ->withHeaders(['microservice' => env('MICROSERVICE_SLUG', 'none')])
            ->withHeaders(Authenticate::headers());
    }
}
