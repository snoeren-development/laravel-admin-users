<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

use SnoerenDevelopment\AdminUsers\Adminable;
use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{
    use Adminable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
    ];
}
