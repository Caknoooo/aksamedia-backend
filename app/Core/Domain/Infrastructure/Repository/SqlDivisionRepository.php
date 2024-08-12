<?php

namespace App\Core\Domain\Infrastructure\Repository;

use App\Core\Domain\Infrastructure\Interfaces\DivisionRepositoryInterface;
use App\Core\Domain\Models\Division\Division;
use App\Core\Domain\Models\Division\DivisionId;
use Illuminate\Support\Facades\DB;

class SqlDivisionRepository implements DivisionRepositoryInterface{
  public function getWithPagination(int $page, int $perPage): array {
    $rows = DB::table('divisions')->skip(($page - 1) * $perPage)->take($perPage)->get();
    if ($rows === null) {
      return [];
    }

    $divisions = [];

    foreach ($rows as $row) {
      $divisions[] = new Division(
        new DivisionId($row->id),
        $row->name,
      );
    }

    return $divisions;
  }

  public function findById(string $id): ?Division {
    $row = DB::table('divisions')->where('id', $id)->first();
    if ($row === null) {
      return null;
    }

    return $this->constructFromRows([$row])[0];
  }

  public function constructFromRows(array $rows): array {
    $divisions = [];
    foreach ($rows as $row) {
      $divisions[] = new Division(
        new DivisionId($row->id),
        $row->name,
      );
    }

    return $divisions;
  }
}
