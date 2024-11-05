<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use App\Models\Traits\RelationHasMany;
use App\Models\Traits\Scopes\HasLocalizableAttributes;
use ErrorException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;
use ReflectionMethod;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BaseModel extends Model
{
    use HasFactory,
        RelationHasMany,
        CreatedBy,
        HasLocalizableAttributes,
        LogsActivity;

    /**
     * @var bool
     */
    protected static bool $logFillable = true;

    /**
     * @var bool
     */
    protected static bool $logOnlyDirty = true;

    /**
     * @param mixed $value
     * @return false|Carbon
     */
    protected function asDateTime($value)
    {
        // Get default timezone from config, or use 'UTC' as a fallback
        $tz = config('app.timezone', 'UTC');

        // If the user is logged in, get their timezone
        if (Auth::check()) {
            $tz = Auth::user()->timezone ?: $tz; // If the user's timezone is null, use the default
        }

        // If the value is already a Carbon instance, just return it
        if ($value instanceof Carbon) {
            return $value->setTimezone($tz); // Set the timezone
        }

        // Convert to Carbon instance and set the timezone
        $value = parent::asDateTime($value);
        return $value->setTimezone($tz); // Set the timezone
    }


    public static function boot() {
        parent::boot();

        static::deleted(function($item) {
            $relationMethods = $item->relationships();
            foreach($relationMethods as $relationMethod){
                $relationMethod->invoke($item)->delete();
            }
        });
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
