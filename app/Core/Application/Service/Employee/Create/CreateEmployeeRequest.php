<?php

namespace App\Core\Application\Service\Employee\Create;

use Illuminate\Http\UploadedFile;

class CreateEmployeeRequest {
  private string $name;

  private UploadedFile $image;

  private string $phone;

  private string $division_id;

  private string $position;

  /**
   * CreateEmployeeRequest constructor.
   * @param string $name
   * @param UploadedFile $image
   * @param string $phone
   * @param string $division_id
   * @param string $position
   */
  public function __construct(string $name, UploadedFile $image, string $phone, string $division_id, string $position) {
    $this->name = $name;
    $this->image = $image;
    $this->phone = $phone;
    $this->division_id = $division_id;
    $this->position = $position;
  }

  /**
   * @return string
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * @return UploadedFile
   */
  public function getImage(): UploadedFile {
    return $this->image;
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
}
