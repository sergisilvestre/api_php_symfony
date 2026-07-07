<?php

namespace App\Auth\Presentation\Http\V1;

use OpenApi\Attributes as OA;
use App\Shared\Helpers\ApiResponseHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Auth\Application\UseCase\UserAuthenticated;
use App\Auth\Domain\Repository\TokenGenerator;
use App\User\Application\UseCase\LoginUser;
use Shared\Infrastructure\Helpers\TimeHelper;

#[Route('/api/v1/auth', name: 'auth.')]
class AuthController extends AbstractController
{
    public function __construct(
        private readonly LoginUser $loginUser,
        private readonly TokenGenerator $auth,
    ) {}

    #[Route('/login', name: 'login', methods: ['POST'])]
    #[OA\Post(
        path: '/api/v1/auth/login',
        summary: 'Login user and get JWT token'
    )]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];

        $credentials = [
            'email' => $data['email']
                ?? $request->request->get('email')
                ?? $request->query->get('email'),

            'password' => $data['password']
                ?? $request->request->get('password')
                ?? $request->query->get('password'),
        ];

        $userInfo = $this->loginUser->execute($credentials);

        dd($credentials, $userInfo);
        
        if (empty($userInfo['token'])) {
            return ApiResponseHelper::error('Unauthorized', 401);
        }

        return ApiResponseHelper::success([
            'token' => $userInfo['token'],
            'ttl'   => $userInfo['ttl'],
        ]);
    }

    #[Route('/check', name: 'check', methods: ['GET'])]
    #[OA\Get(
        path: '/api/v1/auth/check',
        summary: 'Check if authenticated',
        security: [['bearerAuth' => []]]
    )]
    public function check(UserAuthenticated $userAuthenticated): JsonResponse
    {
        $user = $userAuthenticated->execute();

        return ApiResponseHelper::success([
            'message' => $user,
        ]);
    }

    #[Route('/logout', name: 'logout', methods: ['POST'])]
    #[OA\Post(
        path: '/api/v1/auth/logout',
        summary: 'Logout'
    )]
    public function logout(): JsonResponse
    {
        $this->auth->invalidate();

        return ApiResponseHelper::success([
            'message' => 'Successfully logged out',
        ]);
    }

    #[Route('/verify', name: 'verify', methods: ['GET', 'POST'])]
    #[OA\Post(
        path: '/api/v1/auth/verify',
        summary: 'Verify email'
    )]
    public function verify(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $token = $data['token'] ?? $request->query->get('token');


        return ApiResponseHelper::success([
            'message' => 'Email verified successfully',
        ]);
    }

    #[Route('/refresh', name: 'refresh', methods: ['POST'])]
    #[OA\Post(
        path: '/api/v1/auth/refresh',
        summary: 'Refresh token',
        security: [['bearerAuth' => []]]
    )]
    public function refresh(): JsonResponse
    {
        $newToken = $this->auth->refresh();

        return ApiResponseHelper::success([
            'token' => $newToken,
            'ttl' => TimeHelper::addMinutes($this->auth->getTTL()),
        ]);
    }

    #[Route('/revoke', name: 'revoke', methods: ['POST'])]
    #[OA\Post(
        path: '/api/v1/auth/revoke',
        summary: 'Revoke token',
        security: [['bearerAuth' => []]]
    )]
    public function revoke(): JsonResponse
    {
        $this->auth->invalidate();

        return ApiResponseHelper::success([
            'message' => 'Token revoked successfully',
        ]);
    }
}
