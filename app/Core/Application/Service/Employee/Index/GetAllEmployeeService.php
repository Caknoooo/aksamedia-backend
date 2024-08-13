<?php

namespace App\Core\Application\Service\Employee\Index;

use App\Core\Domain\Infrastructure\Interfaces\EmployeeRepositoryInterface;

class GetAllEmployeeService
{
  private EmployeeRepositoryInterface $employee_repository;

  /**
   * GetEmployeeService constructor.
   * @param EmployeeRepositoryInterface $employee_repository
   */
  public function __construct(EmployeeRepositoryInterface $employee_repository)
  {
    $this->employee_repository = $employee_repository;
  }

  public function execute(GetAllEmployeeRequest $request): PaginationResponse
  {
    $page = $request->getPage() ?? 1;
    $per_page = $request->getPerPage() ?? 10;

    $filters = [
      'name' => $request->getName(),
      'division_id' => $request->getDivisionId(),
    ];

    $employees = $this->employee_repository->getWithPagination($page, $per_page, $filters);

    if (empty($employees['data'])) {
      return new PaginationResponse([], $page, 0);
    }

    $employeeResponses = array_map(function ($employee) {
      return new GetAllEmployeeResponse($employee);
    }, $employees['data']);

    return new PaginationResponse($employeeResponses, $page, $employees['max_page'], $per_page);
  }
}
