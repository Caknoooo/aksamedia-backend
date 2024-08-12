<?php

namespace App\Core\Application\Service\Admin\Me;

use App\Core\Domain\Models\Admin\Admin;
use JsonSerializable;

class MeResponse implements JsonSerializable {
  private Admin $admin;

  /**
   * @param Admin $admin
   */
  public function __construct(Admin $admin) {
    $this->admin = $admin;
  }

  public function jsonSerialize(): array {
    return [
      'id' => $this->admin->getId()->toString(),
      'name' => $this->admin->getName(),
      'username' => $this->admin->getUsername(),
      'email' => $this->admin->getEmail()->toString(),
      'phone' => $this->admin->getPhone(),
    ];
  }
}
