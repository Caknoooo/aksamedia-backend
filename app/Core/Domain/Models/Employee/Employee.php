<?php

namespace App\Core\Domain\Models\Employee;

use App\Core\Domain\Models\Division\DivisionId;

class Employee {
  private EmployeeId $id;

  private string $name;

  private string $phone;

  private DivisionId $division_id;

  private string $position;

  private string $image;

  /**
   * @param EmployeeId $id
   * @param string $name
   * @param string $phone
   * @param string $image
   * @param DivisionId $division_id
   * @param string $position
   */
  public function __construct(EmployeeId $id, string $name, string $phone, string $image, DivisionId $division_id, string $position) {
    $this->id = $id;
    $this->name = $name;
    $this->phone = $phone;
    $this->image = $image;
    $this->division_id = $division_id;
    $this->position = $position;
  }

  public static function create(
    string $name,
    string $phone,
    string $image,
    DivisionId $division_id,
    string $position
  ): self {
    return new self(
      EmployeeId::generate(),
      $name,
      $phone,
      $image,
      $division_id,
      $position
    );
  }

  /**
   * @return EmployeeId
   */
  public function getId(): EmployeeId {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getPhone(): string {
    return $this->phone;
  }

  /**
   * @return string
   */
  public function getImage(): string {
    return $this->image;
  }

  /**
   * @return DivisionId
   */
  public function getDivisionId(): DivisionId {
    return $this->division_id;
  }

  /**
   * @return string
   */
  public function getPosition(): string {
    return $this->position;
  }
}
