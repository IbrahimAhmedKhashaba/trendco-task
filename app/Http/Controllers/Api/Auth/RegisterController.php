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

    private $factory, $provider , $cartRepository;

    public function __construct(RegistrationFactoryInterface $factory , CartRepositoryInterface  $cartRepository)
    {
        $this->factory = $factory;
        $this->cartRepository = $cartRepository;
        $this->provider = request()->provider ?? 'email';
    }

    public function register(RegisterRequest $request)
    {
        try {
            $strategy = $this->factory->create($this->provider);
            $data = $strategy->register($request->all());
            Auth::login($data['user']);

            return response()->apiSuccessResponse([
                'user'  => $data['user'],
            ], 'Registration Success');
        } catch (\Exception $e) {
            return response()->apiErrorResponse('Internal server error', 500);
        }
    }
}
