<?php


namespace abeille_mobile_admin\models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Emplacement extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'EMPLACEMENT';
    protected $primaryKey = 'emplacement_id';
    public $timestamps = false;
    //use SoftDeletes;
    //protected $dates = ['deleted_at'];

}