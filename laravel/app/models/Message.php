<?php

class Message extends Eloquent {

    protected $table = 'messages';

    protected $guarded = array('id','updated_at','created_at');
}