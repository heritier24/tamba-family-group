<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyShareSavingTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "family_share_saving_transactions";
}
