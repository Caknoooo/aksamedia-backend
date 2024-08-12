<?php

namespace App\Core\Application\Service\Employee\Update;

use App\Core\Application\Image\ImageUpload;
use App\Core\Domain\Infrastructure\Interfaces\EmployeeRepositoryInterface;
use App\Core\Domain\Models\Division\DivisionId;
use App\Core\Domain\Models\Employee\Employee;
use App\Core\Domain\Models\Employee\EmployeeId;
use App\Exceptions\UserException;

class UpdateEmployeeService
{
  private EmployeeRepositoryInterface $employee_repository;

  /**
   * UpdateEmployeeService constructor.
   * @param EmployeeRepositoryInterface $employee_repository
   */
  public function __construct(EmployeeRepositoryInterface $employee_repository)
  {
    $this->employee_repository = $employee_repository;
  }

  public function execute(UpdateEmployeeRequest $request): void
  {
    $employee = $this->employee_repository->findById($request->getId());
    if (!$employee) {
      UserException::throw('employee not found', 1000, 404);
    }

    if ($request->getImage()) {
      $imageUrl = ImageUpload::create(
        $request->getImage(),
        'employee',
        $request->getId(),
        $request->getName()
      )->upload();
    } else {
      $imageUrl = $employee->getImage();
    }

    $new = new Employee(
      new EmployeeId($request->getId()),
      $request->getName(),
      $request->getPhone(),
      $imageUrl,
      new DivisionId($request->getDivisionId()),
      $request->getPosition()
    );


    $this->employee_repository->update(
      $new
    );
  }
}
