<?php

namespace App\Core\Domain\Infrastructure\Repository;

use App\Core\Domain\Infrastructure\Interfaces\EmployeeRepositoryInterface;
use App\Core\Domain\Models\Division\Divisionid;
use App\Core\Domain\Models\Employee\Employee;
use App\Core\Domain\Models\Employee\EmployeeId;
use Illuminate\Support\Facades\DB;

class SqlEmployeeRepository implements EmployeeRepositoryInterface
{
  public function persist(Employee $employee): void
  {
    DB::table('employees')->upsert([
      'id' => $employee->getId()->toString(),
      'division_id' => $employee->getDivisionId()->toString(),
      'name' => $employee->getName(),
      'phone' => $employee->getPhone(),
      'position' => $employee->getPosition(),
      'image' => $employee->getImage(),
    ], 'id');
  }

  public function findById(string $id): ?Employee
  {
    $row = DB::table('employees')->where('id', $id)->first();
    if ($row === null) {
      return null;
    }

    return $this->constructFromRows([$row])[0];
  }

  public function delete(Employee $employee): void
  {
    DB::table('employees')->where('id', $employee->getId()->toString())->delete();
  }

  public function update(Employee $employee): void
  {
    DB::table('employees')->where('id', $employee->getId()->toString())->update([
      'division_id' => $employee->getDivisionId()->toString(),
      'name' => $employee->getName(),
      'phone' => $employee->getPhone(),
      'position' => $employee->getPosition(),
      'image' => $employee->getImage(),
    ]);
  }

  public function getWithPagination(int $page, int $per_page, array $filters): array
  {
    $query = DB::table('employees')
      ->join('divisions', 'employees.division_id', '=', 'divisions.id')
      ->select('employees.*', 'divisions.name as division_name', 'divisions.id as division_id');

    if (!empty($filters['name'])) {
      $query->where('employees.name', 'LIKE', '%' . $filters['name'] . '%');
    }

    if (!empty($filters['division_id'])) {
      $query->where('division_id', $filters['division_id']);
    }

    $rows = $query->paginate($per_page, ['*'], 'page', $page);

    $employees = [];

    foreach ($rows as $row) {
      $employees[] = [
        'id' => $row->id,
        'name' => $row->name,
        'phone' => $row->phone,
        'image' => $row->image,
        'position' => $row->position,
        'division_id' => $row->division_id,
        'division_name' => $row->division_name,
      ];
    }

    return [
      'data' => $employees,
      'max_page' => ceil($rows->total() / $per_page)
    ];
  }

  public function constructFromRow($row): Employee
  {
    return new Employee(
      new EmployeeId($row->id),
      $row->name,
      $row->phone,
      $row->image,
      new DivisionId($row->division_id),
      $row->position
    );
  }

  public function constructFromRows(array $rows): array
  {
    $employees = [];
    dd($rows);
    foreach ($rows as $row) {
      $employees[] = new Employee(
        new EmployeeId($row->id),
        $row->name,
        $row->phone,
        $row->image,
        new DivisionId($row->division_id),
        $row->position
      );
    }
    return $employees;
  }
}
