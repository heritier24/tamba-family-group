<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyLoanMembers extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "family_loan_members";
}
