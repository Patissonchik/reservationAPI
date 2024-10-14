<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class AuthService
{
    public function register(array $data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = JWTAuth::fromUser($user);

            return ['user' => $user, 'token' => $token];
        } catch (Exception $e) {
            throw new Exception('Ошибка регистрации: ' . $e->getMessage());
        }
    }

    public function login(array $credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return null;
            }

            return $token;
        } catch (Exception $e) {
            throw new Exception('Ошибка входа: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (Exception $e) {
            throw new Exception('Ошибка выхода: ' . $e->getMessage());
        }
    }
}
