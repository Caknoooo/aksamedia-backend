<?php

namespace App\Core\Application\Service\Admin\Register;

use APp\Core\Domain\Infrastructure\Interfaces\AdminRepositoryInterface;
use App\Core\Domain\Models\Admin\Admin;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;

class RegisterService {
  private AdminRepositoryInterface $adminRepository;

  /**
   * @param AdminRepositoryInterface $adminRepository
   */
  public function __construct(AdminRepositoryInterface $adminRepository) {
    $this->adminRepository = $adminRepository;
  }

  /**
   * @param RegisterRequest $request
   * @return void
   */
  public function execute(RegisterRequest $request): void {
    $registerUser = $this->adminRepository->findByEmail($request->getEmail());
    if ($registerUser !== null) {
      UserException::throw('email already exists', 400);
    }

    $admin = Admin::create(
      new Email($request->getEmail()),
      $request->getPassword(),
      $request->getName(),
      $request->getPhone(),
      $request->getUsername()
    );

    $this->adminRepository->persist($admin);
  }
}
