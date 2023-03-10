<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyHouseMembers extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "family_house_members";
}
