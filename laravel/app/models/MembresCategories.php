<?php

class MembresCategories extends Eloquent {

    protected $table = 'lien_categories_membres';

    protected $guarded = array('id','updated_at','created_at');
}