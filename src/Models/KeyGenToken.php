<?php

namespace Equidna\KeyGen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class KeyGenToken extends Model
{
    protected $table      = 'KeyGenTokens';
    protected $primaryKey = 'token';
    protected $keyType    = 'string';

    public $timestamps   = false;
    public $incrementing = false;

    protected $hidden = [];

    protected $fillable = [
        'token',
        'tokeneable_id',
        'tokeneable_type',
        'nombre',
    ];

    public function tokeneable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'tokeneable_type', 'tokeneable_id');
    }
}
