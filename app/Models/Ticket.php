<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'user_id',
        'assigned_it_id',
    ];

    /**
     * Użytkownik, który utworzył zgłoszenie.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Pracownik IT, do którego przypisano zgłoszenie.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_it_id');
    }

    /**
     * Wiadomości w ramach zgłoszenia.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
