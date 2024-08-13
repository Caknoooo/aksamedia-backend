<?php

namespace App\Core\Application\Service\Division\Index;

use App\Core\Domain\Infrastructure\Interfaces\DivisionRepositoryInterface;

class GetAllDivisionService
{
  private DivisionRepositoryInterface $division_repository;

  /**
   * GetAllDivisionService constructor.
   * @param DivisionRepositoryInterface $division_repository
   */
  public function __construct(DivisionRepositoryInterface $division_repository)
  {
    $this->division_repository = $division_repository;
  }

  /**
   * @param GetAllDivisionRequest $request
   * @return array
   */
  public function execute(GetAllDivisionRequest $request): PaginationResponse
  {
    $page = $request->getPage() ?? 1;
    $per_page = $request->getPerPage() ?? 10;
    $name = $request->getName();

    $divisions = $this->division_repository->getWithPagination($page, $per_page, $name);

    if (empty($divisions['data'])) {
      return new PaginationResponse([], $page, 0);
    }

    $divisionResponses = array_map(function ($division) {
      return new GetAllDivisionResponse($division);
    }, $divisions['data']);

    return new PaginationResponse($divisionResponses, $page, $divisions['max_page'], $per_page);
  }
}
