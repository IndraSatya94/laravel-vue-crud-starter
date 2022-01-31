<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    // protected $table = "reports";
    // protected $primaryKey = "id";
    protected $fillable = [
        'subject', 'description', 'reportstatus_id', 'reporttype_id', 'user_id'
    ];

    public function reporttype()
    {
        return $this->belongsTo(ReportType::class);
    }

    public function reportstatus()
    {
        return $this->belongsTo(ReportStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
