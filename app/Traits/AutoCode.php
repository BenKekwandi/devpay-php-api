<?php


namespace App\Traits;


/**
 * If there is a field named code in the table, it automatically fills this field.
 */
trait AutoCode{

    /**
     * @return void
     */
    public static function bootAutoCode() : void
    {
        static::creating(function ($model) {
            $model->code = uniqid();
        });
    }
}