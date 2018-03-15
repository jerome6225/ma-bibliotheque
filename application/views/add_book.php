<div class="col-xs-12 col-md-10 add_book_form">
    <h1>Enregistrer un livre</h1>
    <form id="form_login" method="post" action="<?php echo $url_add_book ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="isbn">Code ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" aria-describedby="isbnHelp" placeholder="Saisissez l'ISBN du livre" value="<?php echo set_value('isbn'); ?>" />
            <?php echo form_error('isbn'); ?>
        </div>
        <div class="form-group input-group">
            <label class="input-group-btn">
                <span class="btn btn-primary">
                    Livre Numérique… <input style="display: none;" id="book" name="book"  multiple="" type="file" accept=".epub, .azw, .tpz">
                </span>
            </label>
            <input class="form-control" readonly="" type="text">
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer le livre</button>
    </form>
</div>