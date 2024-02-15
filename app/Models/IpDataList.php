<?php

namespace App\Models;

use App\Enums\AddressCondition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpDataList extends Model
{
    use HasFactory;

    protected $table = 'ip_data_list';

    protected $guarded = [];

    protected $casts = [
        'ip_condition' => AddressCondition::class,
        'asn_condition' => AddressCondition::class,
    ];
}
