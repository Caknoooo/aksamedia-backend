<?php

namespace App\Core\Domain\Infrastructure\Repository;

use App\Core\Domain\Infrastructure\Interfaces\AdminRepositoryInterface;
use App\Core\Domain\Models\Admin\Admin;
use App\Core\Domain\Models\Admin\AdminId;
use App\Core\Domain\Models\Email;
use Illuminate\Support\Facades\DB;

class SqlAdminRepository implements AdminRepositoryInterface
{
  public function persist(Admin $admin): void
  {
    DB::table('admins')->upsert([
      'id' => $admin->getId()->toString(),
      'email' => $admin->getEmail(),
      'password' => $admin->getHashPassword(),
      'name' => $admin->getName(),
      'phone' => $admin->getPhone(),
      'username' => $admin->getUsername(),
    ], 'id');
  }

  public function findByEmail(string $email): ?Admin
  {
    $row = DB::table('admins')->where('email', $email)->first();
    if ($row === null) {
      return null;
    }

    return $this->constructFromRows([$row])[0];
  }

  public function findById(string $id): ?Admin
  {
    $row = DB::table('admins')->where('id', $id)->first();
    if ($row === null) {
      return null;
    }

    return $this->constructFromRows([$row])[0];
  }

  public function delete(Admin $admin): void
  {
    DB::table('admins')->where('id', $admin->getId()->toString())->delete();
  }

  public function update(Admin $admin): void
  {
    DB::table('admins')->where('id', $admin->getId()->toString())->update([
      'email' => $admin->getEmail(),
      'password' => $admin->getHashPassword(),
      'name' => $admin->getName(),
      'phone' => $admin->getPhone(),
      'username' => $admin->getUsername(),
    ]);
  }

  public function getWithPagination(int $page, int $perPage): array
  {
    $rows = DB::table('admins')->offset(($page - 1) * $perPage)->limit($perPage)->get();

    $admins = [];

    foreach ($rows as $row) {
      $admins[] = new Admin(
        new AdminId($row->id),
        new Email($row->email),
        $row->password,
        $row->name,
        $row->phone,
        $row->username
      );
    }

    return [
      'data' => $admins,
      'max_page' => ceil($rows->count() / $perPage),
    ];
  }

  public function constructFromRows(array $rows): array
  {
    $admins = [];
    foreach ($rows as $row) {
      $admins[] = new Admin(
        new AdminId($row->id),
        new Email($row->email),
        $row->password,
        $row->name,
        $row->phone,
        $row->username
      );
    }
    return $admins;
  }
}
