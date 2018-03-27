<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#jr-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="jr-navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo site_url(array('homePage', 'deconnexion')) ?>">Déconnexion</a></li>
                <li><a href="<?php echo site_url(array('bookList', 'list')) ?>">Mes livres</a></li>
                <li><a href="<?php echo site_url(array('bookAdd', 'displayAddBook')) ?>">Enregistrer un livre</a></li>
                <?php if (isset($genres)): ?>
                    <li class="submenu"><a href="#">Trier par genre</a>
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
                        </ul>
                    </li>
                <?php endif ?>
                <li>
                    <a href="#">
                        <form class="form-inline" method="post" action="<?php echo site_url(array('bookSearch', 'search')) ?>">    
                            <input type="text" class="form-control autocomplete-input search" id="search-mobile" name="search" placeholder="Rechercher..." value="" data-action="<?php echo site_url(array('bookSearch', 'ajaxSearch')) ?>" />
                            <button type="submit" class="btn btn-primary">Rechercher</button>
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>