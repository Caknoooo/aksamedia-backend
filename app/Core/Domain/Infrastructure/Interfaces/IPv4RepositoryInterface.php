<?php

namespace App\Core\Domain\Infrastructure\Interfaces;

interface IPv4RepositoryInterface
{
    public function getIPv4(): string;
}
