<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['name', 'secure'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isAllowedUser(User $user): bool
    {
        return $this->user_id == $user->id or $this->user_id == $user->parent_id;
    }

    public function getUrl(): string
    {
        return ($this->isSecure ? "https://" : "http://") . $this->name;
    }
}
