<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportStatus extends Model
{
    protected $table = "reportstatuses";
    protected $fillable = ['name'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
