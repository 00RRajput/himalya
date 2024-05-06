<?php

namespace App\Imports;

use App\Http\Traits\BaseTrait;
use App\Models\District;
use App\Models\RoutePlan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class RoutePlanImport
{
    public function collection(Collection $rows)
    {
        return $rows;
    }
}
