<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WriteableBox extends Model
{
    use HasFactory;

    protected $table = 'cms_writeable_boxes';

    protected $guarded = [];

    public $timestamps = false;
}
