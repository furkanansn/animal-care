<?php

namespace App\Http\Controllers\Api;

use App\Models\Donation;

class DonationController extends ApiBaseController
{
    public mixed $model = Donation::class;

    public string $pluralName = 'Bağışlar';

    public string $singularName = 'Bağış';

    public array $with = [];

    public array|string|null $rel = [];
}
