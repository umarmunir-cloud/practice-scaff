<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Str;

class Manager extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'manager_post';


    protected $fillable = [
        'name',
        'slug',
        'category_id',
    ];


    protected $casts = [
        'category_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Manager')
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Managercategory::class, 'category_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'post_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'post_user',
            'post_id',
            'user_id'
        );
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoDetails::class, 'seoable');
    }
}
