<?php

namespace App\Core\Application\Service\Employee\Index;

class GetAllEmployeeRequest {
  private ?int $page;

  private ?int $per_page;

  private ?string $name;

  private ?string $division_id;
  /**
   * GetEmployeeRequest constructor.
   * @param int|null $page
   * @param int|null $per_page
   * @param string|null $name
   * @param string|null $division_id
   */
  public function __construct(?int $page, ?int $per_page, ?string $name, ?string $division_id) {
    $this->page = $page;
    $this->per_page = $per_page;
    $this->name = $name;
    $this->division_id = $division_id;
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

  /**
   * @return string|null
   */
  public function getDivisionId(): ?string {
    return $this->division_id;
  }
}
