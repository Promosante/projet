<?php

class Questionnaire extends Eloquent {

    protected $table = 'questionnaires';

    protected $guarded = array('id','updated_at','created_at');
}