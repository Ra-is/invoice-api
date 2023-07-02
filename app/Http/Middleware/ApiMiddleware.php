<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->getUser(); // get user from header
        $password = $request->getPassword(); // get password from header

        if (!empty($user) && !empty($password))
        {
            if ($user == 'testuser' && $password == 'testpassword')
            {
                return $next($request);
            }
            else
            {
                $response = [
                    'success' => false,
                    'message' => 'You are not unauthorized to use this API endpoint'
                ];

                return response()->json($response,401);
            }
        }
        else
        {
            $response = [
                'success' => false,
                'message' => 'Please provide both username and password for API'
            ];

            return response()->json($response,401);

        }
    }
}
