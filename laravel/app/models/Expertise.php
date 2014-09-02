<?php

class Expertise extends Eloquent {

    protected $table = 'expertises';

    protected $guarded = array('id','updated_at','created_at');
}