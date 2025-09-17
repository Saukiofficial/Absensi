<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'card_uid',
        'device_id',
        'method',
        'status',
        'recorded_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * PERBAIKAN: Menambahkan casting agar 'recorded_at' selalu menjadi objek Carbon.
     *
     * @var array
     */
    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    /**
     * Get the user that owns the attendance record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

