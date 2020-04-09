<?php

namespace App;

use Illuminate\Support\Facades\Auth;
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

    public function favorites()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }


    /**
     * Morphed relation
     */

    public function votes()
    {
        return $this->morphToMany(User::class,'vote')->withTimestamps();
    }

    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }



    public function getUrlAttribute(){
        return "/questions/{$this->slug}";
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

    public function markBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoriteAttribute()
    {

        return $this->favorites()->where('user_id',Auth::id())->count() > 0;
    }


    public function vote(int $vote)
    {
        $this->votes()->attach(Auth::id(),['vote'=>$vote]);
        if ($vote < 0)
        {
            $this->decrement('votes_count');
        }
        else
        {
            $this->increment('votes_count');
        }
    }

    public function updateVote(int $vote)
    {
        $this->votes()->updateExistingPivot(\auth()->id(),['vote'=>$vote]);
        if ($vote < 0)
        {
            $this->decrement('votes_count');

            $this->decrement('votes_count');
        }
        else
        {
            $this->increment('votes_count');
            $this->increment('votes_count');
        }
    }
}