<?php

namespace  App\Core\Domain\Models\Admin;

class AdminAccount {
  private AdminId $admin_id;

  /**
   * @param AdminId $admin_id
   */
  public function __construct(AdminId $admin_id) {
    $this->admin_id = $admin_id;
  }

  /**
   * @return AdminId
   */
  public function getAdminId(): AdminId {
    return $this->admin_id;
  }
}
