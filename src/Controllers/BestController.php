<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\CategoryService;

class BestController extends Controller
{
    private \PDO $pdo;

    private CategoryService $service;

    public function index(): void
    {

        $config = new \App\Kernel\Config\Config();
        $driver = $config->get('database.driver');
        $host = $config->get('database.host');
        $port = $config->get('database.port');
        $database = $config->get('database.database');
        $username = $config->get('database.username');
        $password = $config->get('database.password');
        $charset = $config->get('database.charset');

        try {
            $this->pdo = new \PDO(
                "$driver:host=$host;port=$port;dbname=$database;charset=$charset",
                $username,
                $password
            );
        } catch (\PDOException $exception) {
            exit("Database connection failed: {$exception->getMessage()}");
        }

        $sql = 'SELECT movie_id FROM `reviews` WHERE rating >= 8 GROUP BY movie_id LIMIT 10';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([]);
        $reviews = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $movieIds = array_map(fn($review) => $review['movie_id'], $reviews);


        if(!empty($movieIds)) {
            $sql = 'SELECT * FROM movies WHERE id IN ('.implode("," , $movieIds).') LIMIT 10';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([]);
            $movies = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $movies = [];
        }



        $this->view('best', [
            'movies' => $movies,
        ]);
    }




    private function service(): CategoryService
    {
        if (!isset($this->service)) {
            $this->service = new CategoryService($this->db());
        }

        return $this->service;
    }
}
