<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

class JwtEnvProcessor implements EnvVarProcessorInterface
{
    public function getEnv(string $prefix, string $name, \Closure $getEnv): mixed
    {
        $env = $getEnv($name);
        
        if ($prefix === 'jwt_key' && is_string($env)) {
            // If the env var contains PEM key content, write it to a temp file
            if (str_contains($env, '-----BEGIN')) {
                $tempDir = sys_get_temp_dir() . '/jwt_keys';
                if (!is_dir($tempDir)) {
                    mkdir($tempDir, 0700, true);
                }
                
                $keyFile = $tempDir . '/' . $name . '.pem';
                file_put_contents($keyFile, $env);
                chmod($keyFile, 0600);
                
                return $keyFile;
            }
        }
        
        return $env;
    }

    public static function getProvidedTypes(): array
    {
        return [
            'jwt_key' => 'string',
        ];
    }
}