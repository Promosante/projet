<?php

class Questions extends Eloquent {

    protected $table = 'questions';

    protected $guarded = array('id','updated_at','created_at');
}