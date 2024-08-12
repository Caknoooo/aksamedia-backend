<?php

namespace App\Core\Domain\Infrastructure\Repository;

use APp\Core\Domain\Infrastructure\Interfaces\AdminRepositoryInterface;
use App\Core\Domain\Infrastructure\Interfaces\JwtManagerRepositoryInterface;
use App\Core\Domain\Models\Admin\Admin;
use App\Core\Domain\Models\Admin\AdminAccount;
use App\Exceptions\UserException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use UnexpectedValueException;

class JwtManagerRepository implements JwtManagerRepositoryInterface
{
  public AdminRepositoryInterface $adminRepository;

  /**
   * @param AdminRepositoryInterface $adminRepository
   */
  public function __construct(AdminRepositoryInterface $adminRepository)
  {
    $this->adminRepository = $adminRepository;
  }

  public function encode(Admin $admin, string $ip): string
  {
    return JWT::encode(
      [
        'admin_id' => $admin->getId()->toString(),
        'exp' => time() + 60 * 60 * 24,
      ],
      config('app.key') . $ip,
      'HS256'
    );
  }

  // saya memiliki endpoint logout yang akan menghapus token / expired token, tolong buatkan fungsi untuk membuat token expired
  public function expire(string $jwt, string $ip): string
  {
    $jwt = JWT::decode(
      $jwt,
      new Key(config('app.key') . $ip, 'HS256')
    );

    return JWT::encode(
      [
        'admin_id' => $jwt->admin_id,
        'is_expired' => true,
        'exp' => time(),
      ],
      config('app.key') . $ip,
      'HS256'
    );
  }

  public function decode(string $jwt, string $ip): AdminAccount
  {
    try {
      $jwt = JWT::decode(
        $jwt,
        new Key(config('app.key') . $ip, 'HS256')
      );

    } catch (ExpiredException $e) {
      UserException::throw('JWT has expired', 902);
    } catch (SignatureInvalidException $e) {
      UserException::throw('JWT signature is invalid', 903);
    } catch (UnexpectedValueException $e) {
      UserException::throw('Unexpected JWT format', 907);
    }

    $admin = $this->adminRepository->findById($jwt->admin_id);
    if ($admin === null) {
      UserException::throw('Admin not found', 901);
    }

    if($admin->getIsLoggedIn() === false) {
      UserException::throw('Admin is logged out, please login again', 904);
    }

    return new AdminAccount($admin->getId());
  }
}
