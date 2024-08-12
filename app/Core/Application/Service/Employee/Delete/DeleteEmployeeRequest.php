<?php

namespace App\Core\Application\Service\Employee\Delete;

class DeleteEmployeeRequest {
  private string $id;

  /**
   * DeleteEmployeeRequest constructor.
   * @param string $id
   */
  public function __construct(string $id) {
    $this->id = $id;
  }

  /**
   * @return string
   */
  public function getId(): string {
    return $this->id;
  }
}
