<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  public static function createImages($postId, $images) {
    foreach ($images as $image) {
      $newImage = new Image();
      $newImage->image_path = $image;
      $newImage->post_id = $postId;
      $newImage->save();
    }
  }

  public function post() {
       return $this->hasOne("App\Post");
  }
}
