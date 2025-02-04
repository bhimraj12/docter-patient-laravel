<?php

namespace App\Models\V1\Appointment;

use App\Models\V1\Doctor\Doctor;
use App\Models\V1\Master\AppointmentStatus;
use App\Models\V1\User\Patient;
use App\Observers\CreateUpdateDeleteObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kblais\QueryFilter\Filterable;

class Appointment extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $guarded = ['id'];

    public static function boot(){
        parent::boot();
        static::observe(CreateUpdateDeleteObserver::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function status()
    {
        return $this->belongsTo(AppointmentStatus::class, 'appointment_status_id');
    }
}
