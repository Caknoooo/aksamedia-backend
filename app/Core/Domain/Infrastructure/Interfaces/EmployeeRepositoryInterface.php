<?php

namespace App\Core\Domain\Infrastructure\Interfaces;

use App\Core\Domain\Models\Employee\Employee;

interface EmployeeRepositoryInterface {
  public function persist(Employee $employee): void;

  public function findById(string $id): ?Employee;

  public function delete(Employee $employee): void;

  public function update(Employee $employee): void;

  public function getWithPagination(int $page, int $perPage, array $filters): array;

  public function constructFromRows(array $rows): array;
}
