<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Factories\RegistrationFactoryInterface;
use App\Interfaces\Repositories\Cart\CartRepositoryInterface;
use App\Traits\ImageManagementTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    use ImageManagementTrait;

    private $factory, $provider;

    public function __construct(RegistrationFactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->provider = request()->provider ?? 'email';
    }

    public function register(RegisterRequest $request)
    {
        try {
            $strategy = $this->factory->create($this->provider);
            $data = $strategy->register($request->all());

            return response()->apiSuccessResponse([
                'data'  => $data,
            ], __('msgs.register_success'));
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
}
