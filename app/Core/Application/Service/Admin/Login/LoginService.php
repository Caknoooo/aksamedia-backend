<?php

namespace App\Core\Application\Service\Admin\Login;

use APp\Core\Domain\Infrastructure\Interfaces\AdminRepositoryInterface;
use App\Core\Domain\Infrastructure\Interfaces\IPv4RepositoryInterface;
use App\Core\Domain\Infrastructure\Interfaces\JwtManagerRepositoryInterface;
use App\Exceptions\UserException;

class LoginService {
  private AdminRepositoryInterface $admin_repository;
  private JwtManagerRepositoryInterface $jwt_manager_repository;
  private IPv4RepositoryInterface $ipv4_repository;

  /**
   * @param AdminRepositoryInterface $admin_repository
   * @param JwtManagerRepositoryInterface $jwt_manager_repository
   * @param IPv4RepositoryInterface $ipv4_repository
   */
  public function __construct(AdminRepositoryInterface $admin_repository, JwtManagerRepositoryInterface $jwt_manager_repository, IPv4RepositoryInterface $ipv4_repository) {
    $this->admin_repository = $admin_repository;
    $this->jwt_manager_repository = $jwt_manager_repository;
    $this->ipv4_repository = $ipv4_repository;
  }

  /**
   * @param LoginRequest $request
   * @return LoginResponse
   */
  public function execute(LoginRequest $request): LoginResponse {
    $admin = $this->admin_repository->findByEmail($request->getEmail());
    if ($admin === null) {
      UserException::throw('email not found', 404);
    }

    $admin->beginVerification()
      ->checkPassword($request->getPassword())
      ->verify();

    $ip = $this->ipv4_repository->getIPv4();
    $token = $this->jwt_manager_repository->encode($admin, $ip);

    return new LoginResponse($token, $admin);
  }
}
