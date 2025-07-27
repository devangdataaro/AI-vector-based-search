<?php

// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenAI\Laravel\Facades\OpenAI;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'sub_category', 'service', 'keywords'];


    public static function getEmbedding(string $text): array
    {
        $response = OpenAI::embeddings()->create([
            'model' => 'text-embedding-3-small',
            'input' => $text,
        ]);

        return $response->embeddings[0]->embedding;
    }

    public static function nearestNeighbors(string $embedding, int $k = 5)
    {
        return self::select('name')
            ->selectRaw('embedding <-> ? as distance', [$embedding])
            ->orderBy('distance')
            ->limit($k)
            ->get();
    }
}
