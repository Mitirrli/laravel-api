<?php

namespace App\Tool;

use Illuminate\Pagination\LengthAwarePaginator;

class Paginator extends LengthAwarePaginator
{
    public function toArray()
    {
        return [
      'data' => $this->items->toArray(),
      'page' => $this->currentPage(),
      'total_num' => $this->total(),
    ];
    }
}
