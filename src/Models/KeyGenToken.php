<?php

namespace Ometra\Genkey\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent model for Caronte users.
 *
 * @author Gabriel Ruelas
 * @license MIT
 * @version 1.1.0
 */
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
        'app_id',
    ];
}
