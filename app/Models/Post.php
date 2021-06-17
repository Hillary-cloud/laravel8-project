<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
//here
    protected $fillable = [
        'body'
    ];

    public function likedBy(User $user){
        return $this->likes->contains('user_id',$user->id);
    }
//trying not to delete posts that don't belong to the user
    public function ownedBy(User $user){
        return $user->id===$this->user_id;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function likes(){
       return $this->hasMany(Like::class);
    }
}
