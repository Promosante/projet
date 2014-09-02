<?php

class MembresActivites extends Eloquent {

    protected $table = 'lien_membres_activites';

    protected $guarded = array('id','updated_at','created_at');
}