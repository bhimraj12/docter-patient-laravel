<?php

namespace App\Models\V1\Master;

use App\Models\V1\Appointment\Appointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kblais\QueryFilter\Filterable;

class AppointmentStatus extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    const PENDING = 1;

    const CANCEL = 2;

    const POSTPONED = 3;

    const APPROVED = 4;

    const DENIED = 5;

    const COMPLETED = 6;
    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'appointment_status_id');
    }
}
