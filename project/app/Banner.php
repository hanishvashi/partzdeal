<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['top1t','top2t','top3t','top4t','top1','top2','top3','top4','bottom1','bottom2','top1l','top2l','top3l','top4l','bottom1l','bottom2l'];
    public $timestamps = false;
}
