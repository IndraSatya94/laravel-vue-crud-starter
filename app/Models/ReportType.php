<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    protected $table = "reporttypes";
    protected $fillable = ['name'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
