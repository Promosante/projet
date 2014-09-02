<?php

class Admin extends Eloquent {

    protected $table = 'administrateurs';

    protected $guarded = array('id','updated_at','created_at');
}