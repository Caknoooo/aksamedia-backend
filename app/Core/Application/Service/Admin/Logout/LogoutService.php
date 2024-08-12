<?php

namespace  App\Core\Application\Service\Admin\Logout;

use APp\Core\Domain\Infrastructure\Interfaces\AdminRepositoryInterface;
use App\Core\Domain\Models\Admin\AdminAccount;
use App\Exceptions\UserException;

class LogoutService {
  private AdminRepositoryInterface $admin_repository;

  /**
   * @param AdminRepositoryInterface $admin_repository
   */
  public function __construct(AdminRepositoryInterface $admin_repository) {
    $this->admin_repository = $admin_repository;
  }

  public function execute(AdminAccount $account) {
    $admin = $this->admin_repository->findById($account->getAdminId()->toString());
    if ($admin === null) {
      UserException::throw('admin not found', 404);
    }

    $this->admin_repository->updateIsLogin($admin->getId()->toString(), false);
  }
}
