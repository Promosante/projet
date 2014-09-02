<?php

class Activite extends Eloquent {

    protected $table = 'activites';

    protected $guarded = array('id','updated_at','created_at');
}