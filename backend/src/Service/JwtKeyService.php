<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class JwtKeyService
{
    private string $privateKeyPath;
    private string $publicKeyPath;
    private string $passphrase;

    public function __construct(
        #[Autowire('%env(JWT_SECRET_KEY)%')] string $privateKey,
        #[Autowire('%env(JWT_PUBLIC_KEY)%')] string $publicKey,
        #[Autowire('%env(JWT_PASSPHRASE)%')] string $passphrase
    ) {
        $this->privateKeyPath = $this->ensureKeyFile($privateKey, 'private.pem');
        $this->publicKeyPath = $this->ensureKeyFile($publicKey, 'public.pem');
        $this->passphrase = $passphrase;
    }

    private function ensureKeyFile(string $keyContent, string $filename): string
    {
        // If it looks like a file path, use it directly
        if (str_starts_with($keyContent, '/') || str_starts_with($keyContent, '%kernel.project_dir%')) {
            return $keyContent;
        }

        // If it looks like key content, write it to a temp file
        if (str_contains($keyContent, '-----BEGIN')) {
            $tempDir = sys_get_temp_dir() . '/jwt_keys';
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0700, true);
            }
            
            $keyPath = $tempDir . '/' . $filename;
            file_put_contents($keyPath, $keyContent);
            chmod($keyPath, 0600);
            
            return $keyPath;
        }

        // Fallback to original value
        return $keyContent;
    }

    public function getPrivateKeyPath(): string
    {
        return $this->privateKeyPath;
    }

    public function getPublicKeyPath(): string
    {
        return $this->publicKeyPath;
    }

    public function getPassphrase(): string
    {
        return $this->passphrase;
    }
}