<?php

namespace Vietstars\DevDebugger\Middleware;

use Closure;
use Illuminate\Http\Request;
use Vietstars\DevDebugger\DevDebugger;

class DebugbarEnabled
{
    /**
     * The DebugBar instance
     *
     * @var DevDebugger
     */
    protected $debugbar;

    /**
     * Create a new middleware instance.
     *
     * @param  DevDebugger $debugbar
     */
    public function __construct(DevDebugger $debugbar)
    {
        $this->debugbar = $debugbar;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->debugbar->isEnabled()) {
            abort(404);
        }

        return $next($request);
    }
}
