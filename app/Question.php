<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\VotableTrait;

class Question extends Model
{
    use VotableTrait;

    protected $fillable = [
        'title', 'body', 'slug'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);

    }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    public function getStatusAttribute()
    {
        if($this->answers_count > 0) {
            if($this->best_answer_id) {
                return 'answered-accepted';
            }
            return 'answered';
        }
        return 'unanswered';
    }

    public function answers()
    {
        return $this->hasMany('App\Answer')
            ->orderBy('votes_count', 'DESC');
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(
            User::class, 'favorites'
        )->withTimestamps();
    }

    public function isFavorited()
    {
        return $this->favorites()
                ->where('user_id', auth()->id())
                ->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getLimitSymbolsAttribute()
    {
       return \Illuminate\Support\Str::limit(strip_tags($this->bodyHtml()), 250);
    }

    public function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }
}
