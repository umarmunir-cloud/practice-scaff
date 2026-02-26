<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Manager extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'manager_post';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Manager')
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'post_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'post_user',   // pivot table
            'post_id',
            'user_id'
        );
    }

    public function seo()
    {
        return $this->morphOne(SeoDetails::class, 'seoable');
    }
}


