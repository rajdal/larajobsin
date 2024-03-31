<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNoOfCompaniesBelongToUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $companies = Company::where('user_id', auth()->id())->count();
        if ($companies > 0) {
            return back()->with('error', 'You can not create more than one company.');
        }

        return $next($request);
    }
}
