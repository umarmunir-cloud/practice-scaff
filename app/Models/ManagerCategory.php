<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Permission;

class Managercategory extends Model
{
    use HasFactory, LogsActivity;

    /**
     * Activity Log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Customizing the log name
            ->useLogName('ManagerCategory')
            // Log changes to all the $fillable
            ->logFillable()
            // Customizing the description
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
            // Logging only the changed attributes
            ->logOnlyDirty()
            // Prevent saving logs if no attributes changed
            ->dontSubmitEmptyLogs();
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manager_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'slug', 'created_at', 'updated_at'
    ];

    /**
     * Relationships
     */

    // Permissions relationship (if applicable)
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'module_id'); // adjust foreign key if needed
    }

    // Users relationship (many-to-many)
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_modules', 'module_id', 'user_id'); // adjust table/columns as per your DB
    }

    // SEO details (polymorphic)
    public function seo()
    {
        return $this->morphOne(SeoDetails::class, 'seoable');
    }
}


