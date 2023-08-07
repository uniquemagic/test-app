<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public const VALIDATOR_RULES = [
        'user_id' => 'required|exists:App\Models\User,id',
        'name'    => 'required|max:255',
    ];

    public const VALIDATOR_MESSAGES = [
        'required'  => 'The :attribute field is required.',
        'exists'    => ':attribute does not exist.'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
