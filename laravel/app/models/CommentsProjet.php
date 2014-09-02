<?php

class CommentsProjet extends Eloquent {

    protected $table = 'commentaires_projets';

    protected $guarded = array('id','updated_at','created_at');
}