<div class="col-xs-12 col-md-10">
    <?php if ($page == 'mon_livre'): ?><h1>Mon livre</h1><?php endif ?>
    <div class="col-xs-3"><img class="col-xs-12" src="<?php echo $img_url ?>" /></div>
    <div class="col-xs-9">
        <div class="col-xs-2">Titre :</div><div class="col-xs-10"><?php echo $title ?></div>
        <div class="col-xs-2">Auteur :</div><div class="col-xs-10"><?php echo $author ?></div>
        <div class="col-xs-2">Genre :</div><div class="col-xs-10"><?php echo $genre ?></div>
        <?php if ($hasEbook): ?><a href="<?php echo $urlEbook ?>">Télécharger le livre</a><?php endif ?>
    </div>
</div>