<div class="col-md-<?php echo isset($cols) ? $cols : 3; ?>">
    <a href="<?php echo the_permalink(); ?>">
        <div class="similar-movies-box">
            <div class="similiar-movies-image">
                <?php the_post_thumbnail(); ?>
            </div>
            <div class="similar-movies-title">
                <h3><?php the_title(); ?></h3>
            </div>
            <div class="similar-movies-action">
                <button href="void(0);" class="button damp-button" onclick="window.location='<?php echo the_permalink(); ?>'">View Movie</button>
            </div>
        </div>
    </a>
</div>