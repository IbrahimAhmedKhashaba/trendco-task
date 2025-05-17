<?php 

namespace App\Services\Auth;

use App\Interfaces\Repositories\Auth\EmailAuthRepositoryInterface;
use App\Interfaces\Services\Auth\AuthStrategyInterface;
use App\Notifications\Auth\CustomVerifyEmail;
use App\Traits\ImageManagementTrait;
use Illuminate\Auth\Events\Registered;
use App\Events\UserRegistered;

class EmailAuthService implements AuthStrategyInterface{
    use ImageManagementTrait;

    private $emailAuthRepository;
    public function __construct(EmailAuthRepositoryInterface $emailAuthRepository){
        $this->emailAuthRepository = $emailAuthRepository;
    }

    public function register(array $data): array
    {
        $user = $this->emailAuthRepository->register($data);
        event(new UserRegistered($user));
        return [
            'user' => $user,
        ];
    }

}