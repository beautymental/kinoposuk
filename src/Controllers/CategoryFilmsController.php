<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\MovieService;

class CategoryFilmsController extends Controller
{
    private MovieService $service;

    public function index(): void
    {
        $category_id = $this->request()->input('id', null);
        $movies = $this->service()->all();
        $currentCategoryMovies = [];

        if($category_id && !empty($movies)) {
            foreach ($movies as $movie) {
                if($movie->categoryId() == $category_id) {
                    array_push($currentCategoryMovies, $movie);
                }
            }
        }

        $this->view('films', [
            'movies' => $currentCategoryMovies,
        ]);
    }

    private function service(): MovieService
    {
        if (! isset($this->service)) {
            $this->service = new MovieService($this->db());
        }

        return $this->service;
    }
}
