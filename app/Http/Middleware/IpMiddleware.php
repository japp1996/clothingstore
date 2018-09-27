<?php

    namespace App\Http\Middleware;
    use App\Libraries\IpCheck;

    use Closure;
    use View;

    class IpMiddleware {

        public function handle($request, Closure $next) {
            View::share('_ip',IpCheck::get());
            return $next($request);
        }
    }
