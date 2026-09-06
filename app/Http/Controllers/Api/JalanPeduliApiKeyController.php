<?php

namespace App\Http\Controllers\Api;

use App\Models\JalanPeduliApiKey;

class JalanPeduliApiKeyController extends BaseApiKeyController
{
  protected function model(): string
  {
    return JalanPeduliApiKey::class;
  }

  protected function keyPrefix(): string
  {
    return 'uptdjb-';
  }
}
