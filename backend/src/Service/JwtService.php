<?php

namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class JwtService
{
    private string $secret;
    private string $algorithm = 'HS256';
    private int $ttl;

    public function __construct(
        #[Autowire('%env(JWT_SECRET)%')] string $secret,
        #[Autowire('%env(int:JWT_TTL)%')] int $ttl = 3600
    ) {
        $this->secret = $secret;
        $this->ttl = $ttl;
    }

    public function encode(array $payload): string
    {
        $payload['exp'] = time() + $this->ttl;
        $payload['iat'] = time();
        
        return JWT::encode($payload, $this->secret, $this->algorithm);
    }

    public function decode(string $jwt): object
    {
        return JWT::decode($jwt, new Key($this->secret, $this->algorithm));
    }

    public function createToken(string $username, array $roles = []): string
    {
        $payload = [
            'sub' => $username,
            'roles' => $roles,
            'iat' => time(),
            'exp' => time() + $this->ttl,
        ];

        return $this->encode($payload);
    }

    public function isTokenValid(string $token): bool
    {
        try {
            $this->decode($token);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getTokenData(string $token): ?object
    {
        try {
            return $this->decode($token);
        } catch (\Exception $e) {
            return null;
        }
    }
}