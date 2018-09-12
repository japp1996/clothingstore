<?php

    namespace App\Http\Middleware;

    use Closure;
    use App\Models\ExchangeRate;
    use View;

    class ExchangeMiddleware {

        public function handle($request, Closure $next) {
            $change = ExchangeRate::orderBy('id','desc')->first()->change;
            View::share('_change',$change);            
            return $next($request);
        }
    }
