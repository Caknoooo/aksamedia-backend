<?php

namespace App\Core\Domain\Models\Admin;

use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Hash;

class Admin
{
  private AdminId $id;

  private Email $email;

  private string $hash_password;

  private string $name;

  private string $phone;

  private string $username;

  private bool $is_logged_in;

  private static bool $verifier = false;

  public function __construct(
    AdminId $id,
    Email $email,
    string $hash_password,
    string $name,
    string $phone,
    string $username,
    bool $is_logged_in = false
  ) {
    $this->id = $id;
    $this->email = $email;
    $this->hash_password = $hash_password;
    $this->name = $name;
    $this->phone = $phone;
    $this->username = $username;
    $this->is_logged_in = $is_logged_in;
  }

  public static function create(
    Email $email,
    string $hash_password,
    string $name,
    string $phone,
    string $username
  ): self {
    return new self(
      AdminId::generate(),
      $email,
      Hash::make($hash_password),
      $name,
      $phone,
      $username
    );
  }

  /**
   * @return AdminId
   */
  public function getId(): AdminId
  {
    return $this->id;
  }

  /**
   * @return Email
   */
  public function getEmail(): Email
  {
    return $this->email;
  }

  /**
   * @return string
   */
  public function getHashPassword(): string
  {
    return $this->hash_password;
  }

  /**
   * @return string
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getPhone(): string
  {
    return $this->phone;
  }

  /**
   * @return string
   */
  public function getUsername(): string
  {
    return $this->username;
  }

  /**
   * @return bool
   */
  public function getIsLoggedIn(): bool
  {
    return $this->is_logged_in;
  }
  

  /**
   * @return bool
   */
  public static function isVerifier(): bool
  {
    return self::$verifier;
  }


  public function beginVerification(): self
  {
    self::$verifier = true;
    return $this;
  }

  public function checkPassword(string $password): self
  {
    self::$verifier &= Hash::check($password, $this->hash_password);
    return $this;
  }

  public function verify(): void {
    if (!self::$verifier) {
      UserException::throw('invalid credentials', 1003, 401);
    }
  }
}
