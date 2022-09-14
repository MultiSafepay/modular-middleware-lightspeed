<?php

namespace Modularlightspeed\Modularlightspeed\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class lightspeed extends Model
{
    use HasFactory;

    protected $table = 'lightspeed';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'api_key',
        'language',
        'shop_id',
        'cluster_id',
        'token',
    ];

    public static function boot() : void
    {
        parent::boot();
        self::createUuid();
    }

    public static function createUuid() : void
    {
        self::creating(function ($model) {
            $uuid = Uuid::uuid4()->toString();
            if (self::find($uuid)) {
                self::createUuid();
                return;
            }
            $model->uuid = $uuid;
        });
    }

    public function refunds()
    {
        return $this->hasMany(lightspeedRefund::class, 'lightspeed_uuid', 'uuid');
    }
}
