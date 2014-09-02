<?php

class Categorie extends Eloquent {

    protected $table = 'categories_activite';

    protected $guarded = array('id','updated_at','created_at');
}