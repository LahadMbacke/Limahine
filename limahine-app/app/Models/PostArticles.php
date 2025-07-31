<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostArticles extends Model
{
    use HasFactory;

    protected $table = 'posts'; // Nom de la table dans la base de données
    protected $fillable = ['title', 'content', 'is_published'];
}