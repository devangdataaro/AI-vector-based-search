<?php
// app/Http/Controllers/SearchController.php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = [];

        if ($query) {
            $embedding = Category::getEmbedding($query);
            $results = Category::nearestNeighbors(json_encode($embedding));
        }

        return view('search', [
            'query' => $query,
            'results' => $results,
        ]);
    }
}

