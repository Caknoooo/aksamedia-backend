<?php

namespace App\Core\Application\Service\Employee\Index;

use JsonSerializable;

class PaginationResponse implements JsonSerializable
{
  private array $employee;
  private int $page;
  private float $max_page;
  private int $per_page;

  /**
   * @param array $employee
   * @param int $page
   * @param float $max_page
   */
  public function __construct(array $employee, int $page, float $max_page, int $per_page = 10)
  {
    $this->employee = $employee;
    $this->page = $page;
    $this->max_page = $max_page;
    $this->per_page = $per_page;
  }

  public function jsonSerialize(): array
  {
    return [
      "employee" => $this->employee,
      "pagination" => [
        "page" => $this->page,
        "max_page" => $this->max_page,
        "count" => count($this->employee),
        "per_page" => $this->per_page
      ],
    ];
  }
}
