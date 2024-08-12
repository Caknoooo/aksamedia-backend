<?php

namespace App\Core\Application\Service\Employee\Delete;

use App\Core\Domain\Infrastructure\Interfaces\EmployeeRepositoryInterface;
use App\Exceptions\UserException;

class DeleteEmployeeService {
  private EmployeeRepositoryInterface $employee_repository;

  /**
   * DeleteEmployeeService constructor.
   * @param EmployeeRepositoryInterface $employee_repository
   */
  public function __construct(EmployeeRepositoryInterface $employee_repository) {
    $this->employee_repository = $employee_repository;
  }

  public function execute(DeleteEmployeeRequest $request): void {
    $employee = $this->employee_repository->findById($request->getId());
    if (!$employee) {
      UserException::throw('employee not found', 1000, 404);
    }

    $this->employee_repository->delete($employee);
  }
}
