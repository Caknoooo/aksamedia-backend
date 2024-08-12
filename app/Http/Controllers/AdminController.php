<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\Admin\Login\LoginRequest;
use App\Core\Application\Service\Admin\Login\LoginService;
use App\Core\Application\Service\Admin\Me\MeService;
use App\Core\Application\Service\Admin\Register\RegisterRequest;
use App\Core\Application\Service\Admin\Register\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
  public function register(Request $request, RegisterService $service): JsonResponse
  {
    $request->validate([
      'email' => 'email|email',
      'name' => 'min:4|max:255|string',
      'username' => 'min:4|max:255|string',
      'phone' => 'min:8|max:255|string',
    ]);

    $req = new RegisterRequest(
      $request->input('email'),
      $request->input('password'),
      $request->input('name'),
      $request->input('username'),
      $request->input('phone'),
    );

    DB::beginTransaction();
    try {
      $service->execute($req);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->errorWithCode($e->getMessage(), $e->getCode());
    }

    return $this->success('berhasil registrasi');
  }

  public function login(Request $request, LoginService $service): JsonResponse
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $req = new LoginRequest(
      $request->input('email'),
      $request->input('password'),
    );

    try {
      $res = $service->execute($req);
    } catch (\Exception $e) {
      return $this->errorWithCode($e->getMessage(), $e->getCode());
    }

    return $this->successWithData($res, 'berhasil login');
  }

  public function me(Request $request, MeService $service): JsonResponse
  {
    $account = $request->get('account');

    try {
      $res = $service->execute($account);
    } catch (\Exception $e) {
      return $this->errorWithCode($e->getMessage(), $e->getCode());
    }

    return $this->successWithData($res, 'berhasil mengambil data');
  }
}
