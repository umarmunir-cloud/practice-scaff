<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Managercategory extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'manager_category';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('ManagerCategory')
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


    public function posts()
    {
        return $this->hasMany(Manager::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'category_user',
            'category_id',
            'user_id'
        );
    }

    public function seo()
    {
        return $this->morphOne(SeoDetails::class, 'seoable');
    }
}
