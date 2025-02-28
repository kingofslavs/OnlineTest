<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Test;
use Illuminate\Http\Request;

class CheckTestOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $testId = $request->route('test') ?? $request->route('id');
        $test = Test::findOrFail($testId);

        if ($test->user_id !== auth()->id()) {
            abort(403, 'У вас нет прав для редактирования этого теста');
        }

        return $next($request);
    }
}