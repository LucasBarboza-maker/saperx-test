<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = "contact";

    public function phone()
    {
        return $this->hasMany(Phone::class);
    }

    protected $fillable = [
        'name',
        'email',
        'birth',
        'cpf'
    ];
}
