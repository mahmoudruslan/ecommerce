<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'user_id'
    ];


//    public function setContentAttribute($value)
//    {
//        if (is_string($value) && $this->isJson($value)) {
//            $value = json_decode($value, true);
//        }
//
//        $this->attributes['content'] = serialize($value);
//    }
//
//    public function getContentAttribute($value)
//    {
//        return unserialize($value);
//    }

}
