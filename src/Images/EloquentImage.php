<?php namespace B50\Forums\Images;

use Eloquent;

class EloquentImage extends Eloquent
{
    public $table = 'lforums_images';
    public $fillable = ['slug', 'title', 'model', 'path'];
}
