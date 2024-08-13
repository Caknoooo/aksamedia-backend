<?php

namespace App\Core\Application\Service\Division\Index;

use JsonSerializable;

class PaginationResponse implements JsonSerializable
{
  private array $division;
  private int $page;
  private float $max_page;
  private int $per_page;

  /**
   * @param array $division
   * @param int $page
   * @param float $max_page
   */
  public function __construct(array $division, int $page, float $max_page, int $per_page = 10)
  {
    $this->division = $division;
    $this->page = $page;
    $this->max_page = $max_page;
    $this->per_page = $per_page;
  }

  public function jsonSerialize(): array
  {
    return [
      "divisions" => $this->division,
      "pagination" => [
        "page" => $this->page,
        "max_page" => $this->max_page,
        "count" => count($this->division),
        "per_page" => $this->per_page
      ],
    ];
  }
}
