<?php

namespace APp\Core\Domain\Infrastructure\Interfaces;

use App\Core\Domain\Models\Admin\Admin;

interface AdminRepositoryInterface
{
  public function persist(Admin $admin): void;

  public function findByEmail(string $email): ?Admin;

  public function findById(string $id): ?Admin;

  public function delete(Admin $admin): void;

  public function update(Admin $admin): void;

  public function getWithPagination(int $page, int $perPage): array;

  public function updateIsLogin(string $adminId, bool $isLoggedIn): void;

  public function constructFromRows(array $rows): array;
}
