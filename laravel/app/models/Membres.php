<?php

class Membres extends Eloquent {

    protected $table = 'membres';

    protected $guarded = array('id','updated_at','created_at');
}