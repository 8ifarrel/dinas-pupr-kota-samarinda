<?php

namespace App\Http\Controllers\Api;

use App\Models\HantuBanyuApiKey;

class HantuBanyuApiKeyController extends BaseApiKeyController
{
  protected function model(): string
  {
    return HantuBanyuApiKey::class;
  }

  protected function keyPrefix(): string
  {
    return 'uptdsdi-';
  }
}
