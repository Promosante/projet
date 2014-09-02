<?php

class Indicateurs extends Eloquent {

    protected $table = 'indicateurs';

    protected $guarded = array('id','updated_at','created_at');
}