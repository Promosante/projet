<?php

class MembresProjets extends Eloquent {

    protected $table = 'lien_projets_membres';

    protected $guarded = array('id','updated_at','created_at');
}