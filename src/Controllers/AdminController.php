<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\CategoryService;
use App\Services\MovieService;

class AdminController extends Controller
{
    public function index(): void
    {
        $categories = new CategoryService($this->db());
        $movies = new MovieService($this->db());



        if(!$this->auth()->check()) {
            $this->redirect('/');
        }

        if($this->auth()->check()) {
            $authUser = $this->db()->get('users', ['email' => $this->auth()->user()->email()])[0];
            if(!$authUser['is_admin']) {
                $this->redirect('/');
            }
        }

        $this->view('admin/index', [
            'categories' => $categories->all(),
            'movies' => $movies->all(),
            'rating' => $this->getRating(),
        ]);
    }

    public function getRating() {
        $config = new \App\Kernel\Config\Config();
        $driver = $config->get('database.driver');
        $host = $config->get('database.host');
        $port = $config->get('database.port');
        $database = $config->get('database.database');
        $username = $config->get('database.username');
        $password = $config->get('database.password');
        $charset = $config->get('database.charset');

        try {
            $pdo = new \PDO(
                "$driver:host=$host;port=$port;dbname=$database;charset=$charset",
                $username,
                $password
            );
        } catch (\PDOException $exception) {
            exit("Database connection failed: {$exception->getMessage()}");
        }

        $sql = 'select (sum(rating)/count(*)) as rating, movie_id from reviews group by movie_id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([]);
        $reviews = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($reviews as $review) {
            $result[$review['movie_id']] = round($review['rating'],2);
        }

        return $result;
    }
}
