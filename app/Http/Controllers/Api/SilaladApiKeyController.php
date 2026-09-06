<?php

namespace App\Http\Controllers\Api;

use App\Models\SilaladApiKey;

class SilaladApiKeyController extends BaseApiKeyController
{
  protected function model(): string
  {
    return SilaladApiKey::class;
  }

  /** UPTD Pengelolaan Air Limbah Domestik, pemilik layanan SILALAD. */
  protected function keyPrefix(): string
  {
    return 'uptdpald-';
  }
}
