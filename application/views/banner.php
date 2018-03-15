
    <div class="col-xs-12 col-md-5">Ma biblioth&egrave;que perso</div>
    <?php if ($session):?>
        <div class="col-xs-12 col-sm-6 col-md-4">Bonjour <?php if (null != $firstname): echo $firstname; endif ?></div>
        <div class="col-sm-6 col-md-3 hidden-xs hidden-sm"> <a class="pull-right" href="<?php echo $url_deconnexion ?>">Deconnexion</a></div>
    <?php endif ?>
