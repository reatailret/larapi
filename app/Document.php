<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    //
    const STATUS_DRAFT='draft';
    const STATUS_PUBLISHED='published';
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
            if(!$post->payload) $post->payload='{}';
            if(!$post->status) $post->status=self::STATUS_DRAFT;
        });
    }
    public function getIncrementing()
    {
        return false;
    }
    public function getKeyType()
    {
        return 'string';
    }
    
}
