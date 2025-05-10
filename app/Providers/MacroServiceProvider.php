<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Response::macro('apiSuccessResponse', function ($data = null, $message = 'Success', $code = 200) {
            return response()->json([
                'status'  => true,
                'message' => $message,
                'data'    => $data,
            ], $code);
        });

        Response::macro('apiErrorResponse', function ($message = 'Error', $code = 400, $data = null) {
            return response()->json([
                'status'  => false,
                'message' => $message,
                'data'    => $data,
            ], $code);
        });
    }
}
