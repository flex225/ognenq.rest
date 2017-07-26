<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  public static function createImages($postId, $images) {
      $returnImages = [];
      foreach ($images as $image) {
        if (file_exists($image)) {
        $newImage = new Image();
        $newImage->image_path = $image;
        $newImage->post_id = $postId;
        array_push($returnImages, $newImage);
        }
      }

    return $returnImages;
  }

  public function post() {
       return $this->hasOne("App\Post");
  }
}
