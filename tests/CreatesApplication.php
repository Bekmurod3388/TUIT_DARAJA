<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    public function createApplication()
    {
        $this->setTestingEnvironment();

        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function setTestingEnvironment(): void
    {
        $variables = [
            'APP_ENV' => 'testing',
            'APP_KEY' => 'base64:6cy0wBJfS5Kn9Qg8lZ2j6e4NisKPIiQQfrv4Et7qL1w=',
            'APP_MAINTENANCE_DRIVER' => 'file',
            'BCRYPT_ROUNDS' => '4',
            'CACHE_STORE' => 'array',
            'DB_CONNECTION' => 'sqlite',
            'DB_DATABASE' => ':memory:',
            'MAIL_MAILER' => 'array',
            'PULSE_ENABLED' => 'false',
            'QUEUE_CONNECTION' => 'sync',
            'SESSION_DRIVER' => 'array',
            'TELESCOPE_ENABLED' => 'false',
        ];

        foreach ($variables as $key => $value) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}
