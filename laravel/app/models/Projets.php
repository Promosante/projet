<?php

class Projets extends Eloquent {

    protected $table = 'projets';

    protected $guarded = array('id','updated_at','created_at');
}