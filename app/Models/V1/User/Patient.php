<?php

namespace App\Models\V1\User;

use App\Models\User;
use App\Models\V1\Appointment\Appointment;
use App\Observers\CreateUpdateDeleteObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kblais\QueryFilter\Filterable;

class Patient extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
