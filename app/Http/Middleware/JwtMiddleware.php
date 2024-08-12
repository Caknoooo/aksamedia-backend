<?php

namespace App\Http\Middleware;

use App\Core\Domain\Infrastructure\Interfaces\IPv4RepositoryInterface;
use App\Core\Domain\Infrastructure\Interfaces\JwtManagerRepositoryInterface;
use App\Exceptions\UserException;
use Closure;
use Exception;
use Illuminate\Http\Request;

class JwtMiddleware {
  private JwtManagerRepositoryInterface $jwtManagerRepository;
  private IPv4RepositoryInterface $ipv4Repository;

  /**
   * @param JwtManagerRepositoryInterface $jwtManagerRepository
   * @param IPv4RepositoryInterface $ipv4Repository
   */
  public function __construct(JwtManagerRepositoryInterface $jwtManagerRepository, IPv4RepositoryInterface $ipv4Repository) {
    $this->jwtManagerRepository = $jwtManagerRepository;
    $this->ipv4Repository = $ipv4Repository;
  }

  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return Response|RedirectResponse
   * @throws Exception
   */
  public function handle(Request $request, Closure $next) {
    $jwt = $request->bearerToken();
    if ($jwt === null) {
      UserException::throw('token is not send', 401);
    }

    $ip = $this->ipv4Repository->getIPv4();
    $account = $this->jwtManagerRepository->decode($jwt, $ip);
    $request->attributes->add(['account' => $account]);

    return $next($request);
  }
}
