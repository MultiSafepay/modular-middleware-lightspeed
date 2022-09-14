<?php

namespace ModularLightspeed\ModularLightspeed\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lightspeedRefund extends Model
{
    use HasFactory;

    protected $table = 'lightspeed_refunds';

    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'invoice_id',
        'order_id',
        'lightspeed_uuid',
    ];

    public function lightspeed()
    {
        return $this->belongsTo(lightspeed::class, 'lightspeed_uuid', 'uuid');
    }
}
