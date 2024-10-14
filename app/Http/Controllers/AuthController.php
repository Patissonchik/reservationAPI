<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Exception;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->register($request->validated());
            return response()->json($data, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ошибка регистрации', 'message' => $e->getMessage()], 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->login($request->validated());

            if (!$token) {
                return response()->json(['error' => 'Несанкционированный доступ'], 401);
            }

            return response()->json(compact('token'));
        } catch (Exception $e) {
            return response()->json(['error' => 'Ошибка входа', 'message' => $e->getMessage()], 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();
            return response()->json(['message' => 'Успешный выход']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ошибка выхода', 'message' => $e->getMessage()], 500);
        }
    }
}
