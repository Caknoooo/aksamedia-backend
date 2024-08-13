<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\Division\Index\GetAllDivisionRequest;
use App\Core\Application\Service\Division\Index\GetAllDivisionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DivisionController extends Controller {
  public function index(Request $request, GetAllDivisionService $service): JsonResponse {
    $req = new GetAllDivisionRequest(
      $request->input('page'),
      $request->input('per_page'),
      $request->input('name')
    );

    $divisions = $service->execute($req);

    return $this->successWithData($divisions, "berhasil mendapatkan data divisi");
  }
}
