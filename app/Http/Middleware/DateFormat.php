<?php

namespace App\Http\Middleware;

use Closure;
use Date;

class DateFormat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (($request->method() == 'POST') || ($request->method() == 'PATCH')) {
            $fields = ['paid_at', 'due_at', 'billed_at', 'invoiced_at', 'started_at', 'ended_at'];

            foreach ($fields as $field) {
                $date = $request->get($field);

                if (empty($date)) {
                    continue;
                }

                $new_date = Date::parse($date)->format('Y-m-d')  . ' ' . Date::now()->format('H:i:s');

                $request->request->set($field, $new_date);
            }
        }

        return $next($request);
    }
}
