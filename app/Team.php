<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Team extends Model
{
    protected $fillable = ['name'];

    public function add($user)
    {
        $this->isTooManyMembers();

        // 判斷　$user 是否　為　model or collection
        $method = $user instanceof User ? 'save': 'saveMany';

        $this->members()->$method($user);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }
    
    public function count()
    {
       return $this->members()->count();
    }

    public function isTooManyMembers()
    {
        if ($this->count() >= $this->size) {
            throw new \Exception;
        }
    }
}
