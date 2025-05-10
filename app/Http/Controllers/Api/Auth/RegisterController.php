<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Factories\RegistrationFactoryInterface;
use App\Traits\ImageManagementTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use GuzzleHttp\Client;

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
        // try {
            $strategy = $this->factory->create($this->provider);
            $data = $strategy->register($request->all());

            return response()->apiSuccessResponse([
                'user'  => $data['user'],
                'token' => $data['token'],
            ], 'Registration Success');
        // } catch (\Exception $e) {
        //     return response()->apiErrorResponse('Internal server error', 500);
        // }
    }
}
