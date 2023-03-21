<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
  
    use HasFactory;

    protected $table = "phone";

  public function contact(){
     return $this->belongsTo(Contact::class);
  }

    protected $fillable = [
        'phone_number',
        'contact_id'
    ];

}