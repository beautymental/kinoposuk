<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var array<\App\Models\Category> $categories
 */
?>

<?php $view->component('start'); ?>

<main>
    <div class="container">
        <h3 class="mt-3">Жанри</h3
        <hr>
        <div class="movies">
            <?php foreach ($categories as $category) { ?>
                <a href="categories/films?id=<?= $category->id() ?>" class="card text-decoration-none movies__item">
                    <img src="https://i.work.ua/cdn-cgi/image/f=jpeg/article/2489b.jpg?v=1713862817" height="200px" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $category->name() ?></h5>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</main>

<?php $view->component('end'); ?>