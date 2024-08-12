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

  public function getWithPagination(int $page, int $perPage): array
  {
    $rows = DB::table('employees')->skip(($page - 1) * $perPage)->take($perPage)->get();
    if ($rows === null) {
      return [];
    }

    $employees = [];

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

  public function constructFromRows(array $rows): array
  {
    $employees = [];
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
