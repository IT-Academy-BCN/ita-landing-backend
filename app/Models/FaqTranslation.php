<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
}
