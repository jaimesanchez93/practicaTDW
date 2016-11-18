<?php
/**
 * Created by PhpStorm.
 * User: saramartinezbayo
 * Date: 29/5/16
 * Time: 13:56
 */
namespace App\Models;

use \Illuminate\Database\Eloquent\Model ;


class Reserva extends Model{
    
    
    protected $table='reservasTDW';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idUsuario','nombre','email','pistas','fecha_reserva','tipo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','updated_at'
    ];

}