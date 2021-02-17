<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

use Illuminate\Database\Eloquent\Model;
use SnoerenDevelopment\AdminUsers\Adminable;

class User extends Model
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
