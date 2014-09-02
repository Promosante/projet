<?php

class Lieux extends Eloquent {

    protected $table = 'lieux';

    protected $guarded = array('id','updated_at','created_at');
}