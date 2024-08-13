<?php

namespace App\Core\Domain\Infrastructure\Repository;

use App\Core\Domain\Infrastructure\Interfaces\DivisionRepositoryInterface;
use App\Core\Domain\Models\Division\Division;
use App\Core\Domain\Models\Division\DivisionId;
use Illuminate\Support\Facades\DB;

class SqlDivisionRepository implements DivisionRepositoryInterface
{
  public function getWithPagination(int $page, int $per_page, ?string $name = null): array
  {
    $query = DB::table('divisions')
      ->select('id', 'name');

    if (!empty($name)) {
      $query->where('name', 'LIKE', '%' . $name . '%');
    }

    $rows = $query->paginate($per_page, ['*'], 'page', $page);

    $divisions = [];

    foreach ($rows as $row) {
      $divisions[] = [
        'id' => $row->id,
        'name' => $row->name,
      ];
    }

    return [
      'data' => $divisions,
      'max_page' => ceil($rows->total() / $per_page),
    ];
  }

  public function findById(string $id): ?Division
  {
    $row = DB::table('divisions')->where('id', $id)->first();
    if ($row === null) {
      return null;
    }

    return $this->constructFromRows([$row])[0];
  }

  public function constructFromRows(array $rows): array
  {
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
