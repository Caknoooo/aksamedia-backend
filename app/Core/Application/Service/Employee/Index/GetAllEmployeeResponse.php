<?php

namespace App\Core\Application\Service\Employee\Index;

use JsonSerializable;

class GetAllEmployeeResponse implements JsonSerializable
{
  private array $employee;

  public function __construct(array $employee)
  {
    $this->employee = $employee;
  }

  public function jsonSerialize(): array
  {
    return [
      "id" => $this->employee['id'],
      "name" => $this->employee['name'],
      "phone" => $this->employee['phone'],
      "image" => $this->employee['image'],
      "division" => [
        "id" => $this->employee['division_id'],
        "name" => $this->employee['division_name'],
      ],
      "position" => $this->employee['position'],
    ];
  }
}
