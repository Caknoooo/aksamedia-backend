<?php

namespace App\Core\Domain\Infrastructure\Interfaces;

use App\Core\Domain\Models\Admin\Admin;
use App\Core\Domain\Models\Admin\AdminAccount;

interface JwtManagerRepositoryInterface
{
    public function encode(Admin $admin, string $ip): string;

    public function decode(string $jwt, string $ip): AdminAccount;
}
