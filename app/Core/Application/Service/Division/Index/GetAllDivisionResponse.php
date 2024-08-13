<?php

namespace App\Core\Application\Service\Division\Index;

use JsonSerializable;

class GetAllDivisionResponse implements JsonSerializable
{
  private array $division;

  public function __construct(array $division)
  {
    $this->division = $division;
  }

  public function jsonSerialize(): array
  {
    return [
      "id" => $this->division['id'],
      "name" => $this->division['name'],
    ];
  }
}
