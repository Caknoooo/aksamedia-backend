<?php

namespace App\Core\Application\Service\Admin\Login;

use App\Core\Domain\Models\Admin\Admin;
use JsonSerializable;

class LoginResponse implements JsonSerializable {
  private string $token;

  private Admin $admin;

  /**
   * @param string $token
   */
  public function __construct(string $token, Admin $admin) {
    $this->token = $token;
    $this->admin = $admin;
  }

  public function jsonSerialize(): array {
    return [
      'token' => $this->token,
      'admin' => [
        'id' => $this->admin->getId()->toString(),
        'name' => $this->admin->getName(),
        'username' => $this->admin->getUsername(),
        'email' => $this->admin->getEmail()->toString(),
        'phone' => $this->admin->getPhone(),
      ],
    ];
  }
}
