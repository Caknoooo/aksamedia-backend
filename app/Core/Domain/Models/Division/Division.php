<?php

namespace App\Core\Domain\Models\Division;

class Division {
  private DivisionId $id;

  private string $name;

  /**
   * @param DivisionId $id
   * @param string $name
   */
  public function __construct(DivisionId $id, string $name) {
    $this->id = $id;
    $this->name = $name;
  }

  /**
   * @return DivisionId
   */
  public function getId(): DivisionId {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getName(): string {
    return $this->name;
  }
}
