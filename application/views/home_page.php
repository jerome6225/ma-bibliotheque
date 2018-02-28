<div class="col-xs-12 col-md-6">
    <form id="form_login" method="post" action="<?php echo $url_login ?>">
        <div class="form-group">
            <label for="mail">Adresse E-mail</label>
            <input type="email" class="form-control" id="mail" name="mail" aria-describedby="mailHelp" placeholder="Saisissez votre e-mail" value="<?php echo set_value('mail'); ?>" />
            <?php echo form_error('mail'); ?>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo set_value('password'); ?>" />
            <?php echo form_error('password'); ?>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>
<div class="col-xs-12 col-md-6">
    <form id="form_create" method="post" action="<?php echo $url_create ?>">
        <div class="form-group">
            <label for="firstname">Pr&eacute;nom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="firstnameHelp" placeholder="Saisissez votre pr&eacute;nom" value="<?php echo set_value('firstname'); ?>" />
            <?php echo form_error('firstname'); ?>
        </div>
        <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="lastnameHelp" placeholder="Saisissez votre nom" value="<?php echo set_value('lastname'); ?>" />
            <?php echo form_error('lastname'); ?>
        </div>
        <div class="form-group">
            <label for="mail">Adresse E-mail</label>
            <input type="email" class="form-control" id="mail" name="mail" aria-describedby="mailHelp" placeholder="Saisissez votre e-mail" value="<?php echo set_value('mail'); ?>" />
            <?php echo form_error('email'); ?>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo set_value('password'); ?>" />
            <?php echo form_error('password'); ?>
        </div>
        <button type="submit" class="btn btn-primary">Cr&eacute;er un compte</button>
    </form>
</div>