<?php

namespace App\Http\Middleware;

use App\Models\KopUser;
use Closure;
use DateTime;
use Illuminate\Http\Request;

class CheckToken
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
        $token = $request->header('token');

        $now = date('Y-m-d');

        if ($token) {
            $check_token = KopUser::where('token', $token)->first();

            if ($check_token) {
                $from_date = date('Y-m-d', strtotime($check_token->last_login));
                $thru_date = $now;

                $date1 = new DateTime($from_date);
                $date2 = new DateTime($thru_date);

                $interval = $date1->diff($date2);

                $expired = $interval->format('%a');

                if ($expired > 7) {
                    $res = array(
                        'status' => FALSE,
                        'data' => $request->all(),
                        'msg' => 'Token Expired',
                        'error' => NULL
                    );
                } else {
                    return $next($request);
                }
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => 'Token Invalid',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $request->all(),
                'msg' => 'No Token Provided',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
