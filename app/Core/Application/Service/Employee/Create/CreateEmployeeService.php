<?php

namespace App\Core\Application\Service\Employee\Create;

use App\Core\Application\Image\ImageUpload;
use App\Core\Domain\Infrastructure\Interfaces\DivisionRepositoryInterface;
use App\Core\Domain\Infrastructure\Interfaces\EmployeeRepositoryInterface;
use App\Core\Domain\Models\Employee\Employee;
use App\Exceptions\UserException;
use Ramsey\Uuid\Uuid;

class CreateEmployeeService
{
  private EmployeeRepositoryInterface $employee_repository;
  private DivisionRepositoryInterface $division_repository;

  /**
   * CreateEmployeeService constructor.
   * @param EmployeeRepositoryInterface $employee_repository
   * @param DivisionRepositoryInterface $division_repository
   */
  public function __construct(EmployeeRepositoryInterface $employee_repository, DivisionRepositoryInterface $division_repository)
  {
    $this->employee_repository = $employee_repository;
    $this->division_repository = $division_repository;
  }

  public function execute(CreateEmployeeRequest $request): void
  {
    $division = $this->division_repository->findById($request->getDivisionId());
    if (!$division) {
      UserException::throw('division not found', 1000, 404);
    }

    $imageUrl = ImageUpload::create(
      $request->getImage(),
      'employee',
      Uuid::uuid4()->toString(),
      $request->getName()
    )->upload();

    $employee = Employee::create(
      $request->getName(),
      $request->getPhone(),
      $imageUrl,
      $division->getId(),
      $request->getPosition()
    );

    $this->employee_repository->persist($employee);
  }
}
