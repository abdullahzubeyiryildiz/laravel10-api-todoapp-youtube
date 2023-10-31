<?php
namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($data)
    {
        return $this->userRepository->register($data);
    }

    public function login($data)
    {
        return $this->userRepository->login($data);
    }

    public function user()
    {
        return $this->userRepository->user();
    }

    public function updateUserImage($userId, $image)
    {
        return $this->userRepository->updateUserImage($userId, $image);
    }
}
