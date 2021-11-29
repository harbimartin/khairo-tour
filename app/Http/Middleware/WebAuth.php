<?php

namespace App\Http\Middleware;

use App\Budget;
use App\BudgetStatusRpt;
use Closure;

class WebAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        session_start();
        $_SESSION['ebudget_approv'] = BudgetStatusRpt::where(['user_id'=>$_SESSION['ebudget_id'], 'status_active'=>1])->count();
        $_SESSION['ebudget_verif'] = Budget::where('budget_status','Verification')->count();
        return $next($request);
    }
}
