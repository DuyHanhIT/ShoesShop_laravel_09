<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Category extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;
    protected $connection =  'mongodb';
    protected $collection = 'category';

    public $timestamps = false;
    protected $fillable = [
        'categoryId',
        'categoryName',
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['categoryId'] = $this->id;
        unset($array['_id']);
        // unset($array['brandId']);
        // unset($array['categoryId']);
        return $array;
    }
}
