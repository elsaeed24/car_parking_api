<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * @group Auth
 */
class LogoutController extends Controller
{

    public function __invoke(Request $request)
    {
       // auth()->user()->currentAccessToken()->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
