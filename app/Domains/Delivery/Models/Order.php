<?php

namespace App\Domains\Delivery\Models;

use App\Domains\Captain\Models\Captain;
use App\Domains\Delivery\Models\Traits\Method\OrderMethod;
use App\Domains\Lookups\Models\City;
use App\Domains\Lookups\Models\VehicleType;
use App\Models\BaseModel;
use App\Domains\Merchant\Models\Merchant;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $captain_id
 * @property integer $city_id
 * @property integer $vehicle_type_id
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property integer $cancelled_by_id
 * @property integer $customer_id
 * @property float $order_amount
 * @property float $delivery_amount
 * @property float $total_amount
 * @property string $order_reference
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $delivery_destination
 * @property boolean $is_instant_delivery
 * @property string $customer_phone
 * @property string $captain_requested_at
 * @property string $captain_accepted_at
 * @property string $captain_arrived_at
 * @property string $captain_started_trip_at
 * @property string $captain_on_the_way_at
 * @property string $delivered_at
 * @property string $cancelled_at
 * @property string $latitude
 * @property string $longitude
 * @property string $notes
 * @property string $captain_picked_order_at
 * @property Merchant $merchant
 * @property User $captain
 * @property float $app_percentage
 * @property float $app_revenue
 * @property float $captain_percentage
 * @property float $captain_revenue
 * @property string $latitude_to
 * @property string $longitude_to
 * @property string $voice_record

 */
class Order extends BaseModel
{
    use OrderMethod,SoftDeletes;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [
        'delivery_destination',
        'is_instant_delivery',
        'city_id',
        'customer_phone',
        'vehicle_type_id',
        'merchant_id',
        'captain_id',
        'created_by_id',
        'updated_by_id',
        'order_amount',
        'delivery_amount',
        'total_amount',
        'order_reference',
        'status',
        'captain_requested_at',
        'captain_accepted_at',
        'captain_arrived_at',
        'captain_started_trip_at',
        'captain_on_the_way_at',
        'delivered_at',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
        'deleted_at',
        'cancel_reason',
        'cancelled_at',
        'cancelled_by_id',
        'notes',
        'captain_picked_order_at',
        'app_percentage',
        'app_revenue',
        'captain_percentage',
        'captain_revenue',
        'latitude_to',
        'longitude_to',
        'voice_record',
        'in_socket_at',
        'request_group_id'


    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function captain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Captain::class,'captain_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cancelledBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'cancelled_by_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class,'city_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicleType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VehicleType::class,'vehicle_type_id');
    }

}
