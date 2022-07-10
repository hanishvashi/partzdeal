<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagesetting extends Model
{
    protected $fillable = ['store_id','contact_success', 'contact_email', 'contact_title', 'contact_text', 'about', 'faq', 'c_status', 'a_status', 'f_status','bn','bnimg'];

    public $timestamps = false;
}
