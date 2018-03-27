<div class="col-xs-12 col-md-10">
    <?php if ($page == 'mon_livre'): ?><h1><?php echo $title ?></h1><?php endif ?>
    <div class="col-xs-12 col-sm-3 img_book"><img class="col-xs-12" src="<?php echo $img_url ?>" /></div>
    <div class="col-xs-12 col-sm-9 description_book">
        <div class="col-xs-4 col-sm-2 author_book">Auteur :</div><div class="col-xs-8 col-sm-10"><?php echo $author ?></div>
        <div class="col-xs-4 col-sm-2 genre_book">Genre :</div><div class="col-xs-8 col-sm-10"><?php echo $genre ?></div>
        <?php if ($hasEbook): ?>
            <div class="col-xs-offset-4 col-xs-8 col-sm-offset-0 col-sm-6 btn btn-default">
                <a href="<?php echo $urlEbook ?>">Télécharger le livre</a>
            </div>
        <?php endif ?>
    </div>
</div>