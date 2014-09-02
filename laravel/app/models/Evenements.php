<?php

class Evenements extends Eloquent {

    protected $table = 'evenements';

    protected $guarded = array('id','updated_at','created_at');
}