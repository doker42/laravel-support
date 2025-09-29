<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetClient extends Model
{
    protected $fillable = [
        'chat_id',
        'target_id',
        'telegraph_client_id',
        'active',
    ];

    protected $table = 'target_client';

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function client()
    {
        return $this->belongsTo(TelegraphClient::class, 'telegraph_client_id', 'id');
    }
}
