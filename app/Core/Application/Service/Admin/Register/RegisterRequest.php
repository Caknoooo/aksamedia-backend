<?php

namespace App\Core\Application\Service\Admin\Register;

class RegisterRequest {
  private string $email;

  private string $password;

  private string $name;

  private string $username;

  private string $phone;

  /**
   * @param string $email
   * @param string $password
   * @param string $name
   * @param string $username
   * @param string $phone
   */
  public function __construct(string $email, string $password, string $name, string $username, string $phone) {
    $this->email = $email;
    $this->password = $password;
    $this->name = $name;
    $this->username = $username;
    $this->phone = $phone;
  }

  /**
   * @return string
   */
  public function getEmail(): string {
    return $this->email;
  }

  /**
   * @return string
   */
  public function getPassword(): string {
    return $this->password;
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
  public function getUsername(): string {
    return $this->username;
  }

  /**
   * @return string
   */
  public function getPhone(): string {
    return $this->phone;
  }
}
