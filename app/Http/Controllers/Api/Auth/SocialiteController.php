<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\Factories\SocialiteFactoryInterface;
use Illuminate\Http\Request;


class SocialiteController extends Controller
{
    //

    private $socialiteFactory;

    public function __construct(SocialiteFactoryInterface $socialiteFactory){
        $this->socialiteFactory = $socialiteFactory;
    }

    public function getSocialiteLink($driver)
    {
        return $this->socialiteFactory->create($driver)->getLink();
    }
}
