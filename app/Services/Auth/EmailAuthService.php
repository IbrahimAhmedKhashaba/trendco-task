<?php 

namespace App\Services\Auth;

use App\Interfaces\Repositories\Auth\EmailAuthRepositoryInterface;
use App\Interfaces\Services\Auth\AuthStrategyInterface;
use App\Notifications\Auth\CustomVerifyEmail;
use App\Traits\ImageManagementTrait;
use Illuminate\Auth\Events\Registered;

class EmailAuthService implements AuthStrategyInterface{
    use ImageManagementTrait;

    private $emailAuthRepository;
    public function __construct(EmailAuthRepositoryInterface $emailAuthRepository){
        $this->emailAuthRepository = $emailAuthRepository;
    }

    public function register(array $data): array
    {
        $user = $this->emailAuthRepository->register($data);
        $user->notify(new CustomVerifyEmail());

        return [
            'user' => $user,
        ];
    }

}