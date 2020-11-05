<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiamondsPackage extends Model
{

    protected $table = 'diamonds_package';

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'package_name', 'no_of_gems', 'status'];

}
