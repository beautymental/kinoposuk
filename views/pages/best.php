<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var array<\App\Models\Category> $categories
 */
?>

<?php $view->component('start'); ?>

<main>
    <div class="container">
        <h3 class="mt-3">Топ фільми</h3>
        <hr>
        <?php if(!empty($movies)) : ?>
        <div class="movies">
            <?php foreach ($movies as $movie) { ?>
                <a href="#" class="card text-decoration-none movies__item">
                    <img src="https://i.work.ua/cdn-cgi/image/f=jpeg/article/2489b.jpg?v=1713862817" height="200px" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $movie['name'] ?></h5>
                        <p class="card-text">Опис фільму: <span class="badge bg-info warn__badge"><?php echo $movie['description'] ?></span></p>
                    </div>
                </a>
            <?php } ?>
        </div>
        <?php else : ?>
            <div class="alert alert-info">Данних поки немає</div>
        <?php endif; ?>
    </div>
</main>

<?php $view->component('end'); ?>