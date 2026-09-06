<?php

namespace App\Http\Controllers\Api;

use App\Models\KelurahanApiKey;

class KelurahanApiKeyController extends BaseApiKeyController
{
  protected function model(): string
  {
    return KelurahanApiKey::class;
  }

  protected function keyPrefix(): string
  {
    return 'kelurahan-';
  }
}
