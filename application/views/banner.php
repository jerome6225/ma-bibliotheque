
    <div class="col-xs-10 col-md-4 jr-title-banner">Ma biblioth&egrave;que perso</div>
    <?php if ($session):?>
        <div class="col-xs-2 jr_sidebar_mobile visible-xs visible-sm">
            <?php include_once('menu_mobile.php') ?>
        </div>
        <div class="col-xs-12 col-sm-10 col-md-6 jr-bonjour-banner">
            <div class="col-xs-6">Bonjour <?php if (null != $firstname): echo $firstname; endif ?></div>
            <form class="form-inline col-xs-6 hidden-xs hidden-sm" method="post" action="<?php echo site_url(array('bookSearch', 'search')) ?>">
                <input type="text" class="form-control autocomplete-input" id="search" name="search" placeholder="Rechercher..." value="" data-action="<?php echo site_url(array('bookSearch', 'ajaxSearch')) ?>" />
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </form>
        </div>
        <div class="col-sm-6 col-md-2 hidden-xs hidden-sm"> <a class="pull-right" href="<?php echo site_url(array('homePage', 'deconnexion')) ?>">Déconnexion</a></div>
    <?php endif ?>
