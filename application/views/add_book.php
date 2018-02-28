<div class="col-xs-10">
    <form id="form_login" method="post" action="<?php echo $url_add_book ?>">
        <div class="form-group">
            <label for="isbn">Code ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" aria-describedby="isbnHelp" placeholder="Saisissez l'ISBN du livre" value="<?php echo set_value('isbn'); ?>" />
            <?php echo form_error('isbn'); ?>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer le livre</button>
    </form>
</div>