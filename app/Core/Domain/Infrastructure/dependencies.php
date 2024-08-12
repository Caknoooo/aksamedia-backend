<?php

use APp\Core\Domain\Infrastructure\Interfaces\AdminRepositoryInterface;
use App\Core\Domain\Infrastructure\Interfaces\IPv4RepositoryInterface;
use App\Core\Domain\Infrastructure\Interfaces\JwtManagerRepositoryInterface;
use App\Core\Domain\Infrastructure\Interfaces\UserRepositoryInterface;
use App\Core\Domain\Infrastructure\Repository\IPv4Repository;
use App\Core\Domain\Infrastructure\Repository\JwtManagerRepository;
use App\Core\Domain\Infrastructure\Repository\SqlAdminRepository;
use App\Core\Domain\Infrastructure\Repository\SqlUserRepository;
use Illuminate\Contracts\Foundation\Application;

/** @var Application $app */
$app->singleton(UserRepositoryInterface::class, SqlUserRepository::class);
$app->singleton(AdminRepositoryInterface::class, SqlAdminRepository::class);
$app->singleton(IPv4RepositoryInterface::class, IPv4Repository::class);
$app->singleton(JwtManagerRepositoryInterface::class, JwtManagerRepository::class);
