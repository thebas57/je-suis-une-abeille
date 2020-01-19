<?php


namespace abeille_mobile_admin\models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Fleur extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'FLEURS';
    protected $primaryKey = 'fleur_id';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

}