<?php

namespace App;

use Illuminate\Support\Str;

class Question extends BaseModel
{
    //We dont want user as the name
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }


    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }

    //accessor method

    public function getUrlAttribute(){
        return "questions/{$this->slug}";
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getAnswersStylesAttribute()
    {
        if ($this->answers_count > 0)
        {
            if($this->best_answer_id)
            {
                return "has-best-answer";
            }
            return "answered";

        }
        return "unanswered";
    }
}