<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'position_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getDepartmentIdAttribute(){
        return Position::query()->find($this->position_id)->department_id;
    }

    public function getDepartmentNameAttribute(){
        return Department::query()->find($this->department_id)->name;
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }

    public function items(){
        return $this->hasManyThrough(DocumentItem::class, Document::class);
    }
}
