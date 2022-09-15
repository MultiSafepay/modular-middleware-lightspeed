<?php

namespace ModularLightspeed\ModularLightspeed\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LightspeedRefund extends Model
{
    use HasFactory;

    protected $table = 'Lightspeed_refunds';

    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'invoice_id',
        'order_id',
        'Lightspeed_uuid',
    ];

    public function Lightspeed()
    {
        return $this->belongsTo(Lightspeed::class, 'Lightspeed_uuid', 'uuid');
    }
}
