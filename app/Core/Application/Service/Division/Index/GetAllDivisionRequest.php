<?php

namespace App\Core\Application\Service\Division\Index;

class GetAllDivisionRequest {
  private ?int $page;

  private ?int $per_page;

  private ?string $name;

  /**
   * GetEmployeeRequest constructor.
   * @param int|null $page
   * @param int|null $per_page
   * @param string|null $name
   */
  public function __construct(?int $page, ?int $per_page, ?string $name) {
    $this->page = $page;
    $this->per_page = $per_page;
    $this->name = $name;
  }

  /**
   * @return int|null
   */
  public function getPage(): ?int {
    return $this->page;
  }

  /**
   * @return int|null
   */
  public function getPerPage(): ?int {
    return $this->per_page;
  }

  /**
   * @return string|null
   */
  public function getName(): ?string {
    return $this->name;
  }
}
