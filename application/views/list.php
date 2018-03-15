<div class="col-xs-12 col-md-10">
    <h1>Ma liste de livre</h1>
    <?php foreach ($books as $book): ?>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <a href="<?php echo site_url(array('book', 'displayBook', $book['id_book'])) ?>">
                <div class="col-xs-12 book_category">
                    <div class="col-xs-5">
                        <div class="category-img row">
                            <img class="col-xs-12" src="<?php echo $book['img_url']?>" />
                        </div>
                    </div>
                    <div class="col-xs-7 block-title">
                        <div class="col-xs-12 no-padding-left no-padding-right book-category-title"><?php echo $book['title'] ?></div>
                        <?php if ($book['ebook']): ?>
                            <div class="no-padding-left no-padding-right book-category-ebook">Vous possedez cet ebook</div>
                        <?php endif ?>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach ?>
</div>