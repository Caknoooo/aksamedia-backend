<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\Employee\Create\CreateEmployeeRequest;
use App\Core\Application\Service\Employee\Create\CreateEmployeeService;
use App\Core\Application\Service\Employee\Delete\DeleteEmployeeRequest;
use App\Core\Application\Service\Employee\Delete\DeleteEmployeeService;
use App\Core\Application\Service\Employee\Index\GetAllEmployeeRequest;
use App\Core\Application\Service\Employee\Index\GetAllEmployeeService;
use App\Core\Application\Service\Employee\Update\UpdateEmployeeRequest;
use App\Core\Application\Service\Employee\Update\UpdateEmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller {
  public function create(Request $request, CreateEmployeeService $service): JsonResponse
  {
    $request->validate([
      'name' => 'min:3|max:255|required|string',
      'phone' => 'min:3|max:255|required|string',
      'image' => 'required|image',
      'division_id' => 'required|string',
      'position' => 'required|string',
    ]);

    $req = new CreateEmployeeRequest(
      $request->input('name'),
      $request->file('image'),
      $request->input('phone'),
      $request->input('division_id'),
      $request->input('position')
    );

    DB::beginTransaction();
    try {
      $service->execute($req);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->errorWithCode($e->getMessage(), $e->getCode());
    }

    return $this->success("berhasil menambahkan karyawan");
  }

  public function delete(Request $request, DeleteEmployeeService $service, string $id): JsonResponse {
    $req = new DeleteEmployeeRequest($id);

    DB::beginTransaction();
    try {
      $service->execute($req);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->errorWithCode($e->getMessage(), $e->getCode());
    }

    return $this->success("berhasil menghapus karyawan");
  }

  public function update(Request $request, UpdateEmployeeService $service, string $id): JsonResponse {
    $request->validate([
      'name' => 'min:3|max:255|string',
      'phone' => 'min:3|max:255|string',
      'image' => 'image',
      'division_id' => 'string',
      'position' => 'string',
    ]);

    $req = new UpdateEmployeeRequest(
      $id,
      $request->input('name'),
      $request->input('phone'),
      $request->input('division_id'),
      $request->input('position'),
      $request->file('image')
    );

    DB::beginTransaction();
    try {
      $service->execute($req);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->errorWithCode($e->getMessage(), $e->getCode());
    }

    return $this->success("berhasil mengupdate karyawan");
  }

  public function index(Request $request, GetAllEmployeeService $service): JsonResponse {
    $req = new GetAllEmployeeRequest(
      $request->query('page'),
      $request->query('per_page'),
      $request->query('name'),
      $request->query('division_id')
    );

    $response = $service->execute($req);

    return $this->successWithData($response, "berhasil mendapatkan data karyawan");
  }
}
