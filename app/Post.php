<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  public function type() {
       return $this->hasOne("App\Type", "id");
  }

  public function tags() {
       return $this->belongsToMany("App\Tag");
  }

  public function images() {
       return $this->hasMany("App\Image");
  }

  public function user() {
       return $this->belongsToOne("App\User");
  }
}
