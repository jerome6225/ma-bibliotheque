<div class="col-xs-12 col-md-10 content_page">
    <?php if ($page == 'mon_livre'): ?><h1><?php echo $title ?></h1><?php endif ?>
    <div class="col-xs-12 col-sm-3 img_book"><img class="col-xs-12" src="<?php echo $img_url ?>" /></div>
    <div class="col-xs-12 col-sm-9 description_book">
        <div class="col-xs-4 col-sm-2 author_book">Déjà lu :</div>
        <div class="col-xs-8 col-sm-10">
            <span class="glyphicon<?php if ($read): ?> glyphicon-ok<?php else: ?> glyphicon-remove<?php endif; ?> jr-glyphicon" data-customer="<?php echo $this->session->userdata('member-id') ?>" data-book="<?php echo $idBook ?>" data-action="<?php echo site_url(array('book', 'toggleReadBookAjax')) ?>" aria-hidden="true"></span>
        </div>
        <div class="col-xs-4 col-sm-2 author_book">Auteur :</div>
        <div class="col-xs-8 col-sm-10">
            <?php if ($author != ''):
                echo $author;
            else: 
                echo 'Non renseigné';
            endif; ?>
        </div>
        <div class="col-xs-4 col-sm-2 genre_book">Genre :</div>
        <div class="col-xs-8 col-sm-10">
            <?php if ($genre != ''):
                echo $genre;
            else: 
                echo 'Non renseigné';
            endif; ?>
        </div>
        <?php if ($isDescription): ?>
            <div class="col-xs-4 col-sm-2 description_book">Résumé :</div>
            <div class="col-xs-8 col-sm-10"><?php echo $resume ?></div>
        <?php else: ?>
            <?php if ($hasEbook): ?>
                <div id="description" data-action="<?php echo site_url(array('book', 'setDescritionAjax')) ?>" data-id_book="<?php echo $id_book ?>"></div>
            <?php endif ?>
        <?php endif ?>
        <?php if ($hasEbook): ?>
            <div class="col-xs-offset-4 col-xs-8 col-sm-offset-2 col-sm-6 btn btn-default to_download_book">
                <a href="<?php echo $urlEbook ?>">Télécharger le livre</a>
            </div>
            <div class="row"></div>
            <div class="col-xs-offset-4 col-xs-8 col-sm-offset-2 col-sm-6 btn btn-default to_read_book">
                <a href="#">Lire le livre</a>
            </div>
        <?php endif ?>
    </div>
</div>
<?php if ($hasEbook): ?>
</div>
    <div class="read_book" style="display: none;">
        <?php include_once('reader.php') ?>
    
    <script>
        var urlEbook      = '<?php echo $urlEbookJs ?>';
        var hasEbook      = <?php echo $hasEbook ?>;
        var isDescription = <?php echo $isDescription ?>;
    </script>
<?php else: ?>
    <script>
        var hasEbook      = <?php echo $hasEbook ?>;
        var isDescription = <?php echo $isDescription ?>;
    </script>
<?php endif ?>