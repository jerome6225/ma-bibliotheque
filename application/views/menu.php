<!-- sidebar area start -->
    <div class="">			
        <ul class="nav nav-pills">
            <li class="active">
                <a href="<?php echo site_url(array('bookList', 'list')) ?>">
                    <img src="<?php echo img_url('books-stack-of-three.png') ?>" />  Mes livres
                </a>
            </li>
            <li class="active">
                <a href="<?php echo site_url(array('bookList', 'list', 'already_read')) ?>">
                    <img src="<?php echo img_url('books-stack-of-three.png') ?>" />  Mes livres Lus
                </a>
            </li>
            <li class="active">
                <a href="<?php echo site_url(array('bookList', 'list', 'not_read')) ?>">
                    <img src="<?php echo img_url('books-stack-of-three.png') ?>" />  Mes livres à lire
                </a>
            </li>
            <li class="active">
                <a href="<?php echo site_url(array('bookAdd', 'displayAddBook')) ?>">
                    <img src="<?php echo img_url('open-book.png') ?>" />  Enregistrer un livre
                </a>
            </li>
            <?php if (isset($genres)): ?>
                <li class="active submenu"><a href="#"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>  Trier par genre</a>
                    <ul class="inactive nav nav-pills nav-pills-submenu" style="display: none;">
                        <li>
                            <a class="genre-link" data-genre="0" data-action="<?php echo site_url(array('bookList', 'ajaxList')) ?>" href="#">
                                Tout voir
                            </a>
                        </li>
                        <?php foreach ($genres as $genre): ?>
                            <li>
                                <a class="genre-link" data-genre="<?php echo $genre ?>" data-action="<?php echo site_url(array('bookList', 'ajaxList')) ?>" href="#">
                                    <?php echo $genre ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </li>
                </li>
            <?php endif ?>
        </ul>
    </div>
<!-- sidebar area end -->