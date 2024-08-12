<?php

namespace App\Core\Application\Service\Employee\Update;

use Illuminate\Http\UploadedFile;

class UpdateEmployeeRequest {
  private string $id;

  private string $name;

  private string $phone;

  private string $division_id;

  private string $position;

  private UploadedFile $image;

  /**
   * UpdateEmployeeRequest constructor.
   * @param string $id
   * @param string $name
   * @param string $phone
   * @param string $division_id
   * @param string $position
   * @param UploadedFile $image
   */
  public function __construct(string $id, string $name, string $phone, string $division_id, string $position, UploadedFile $image) {
    $this->id = $id;
    $this->name = $name;
    $this->phone = $phone;
    $this->division_id = $division_id;
    $this->position = $position;
    $this->image = $image;
  }

  /**
   * @return string
   */
  public function getId(): string {
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
  public function getDivisionId(): string {
    return $this->division_id;
  }

  /**
   * @return string
   */
  public function getPosition(): string {
    return $this->position;
  }

  /**
   * @return UploadedFile
   */
  public function getImage(): UploadedFile {
    return $this->image;
  }
}
