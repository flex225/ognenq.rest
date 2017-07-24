<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  public function posts() {
       return $this->belongsToMany("App\Post");
  }

  public function parent() {
       return $this->belongsToOne(static::class, 'parent_id');
  }

  public function sub_tags() {
       return $this->belongsToMany(static::class, 'parent_id');
  }

  public static function getAllTags() {
       return Tag::with(['sub_tags' => function ($query) {
            $query->orderby(DB::raw("case name when 'Այլ' then 1 else 0 end"));
       }])->whereNull('parent_id')->get();
  }
}
