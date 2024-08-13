<?php

namespace App\Core\Domain\Infrastructure\Interfaces;

use App\Core\Domain\Models\Division\Division;

interface DivisionRepositoryInterface {
  public function getWithPagination(int $page, int $perPage, ?string $name = null): array;

  public function findById(string $id): ?Division;

  public function constructFromRows(array $rows): array;
}
