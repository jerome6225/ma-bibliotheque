$(function(){
    $(document).on('click', 'li.submenu', function(e){
        var block = $(this).children('ul');
        block.toggleClass('inactive');
        if (block.hasClass('inactive')) {
            block.hide(200, 'linear');
        }
        else {
            block.show(200, 'linear');
        }
    });

    if (hasEbook != 0) {
        "use strict";

            document.onreadystatechange = function () {
              if (document.readyState == "complete") {
                EPUBJS.filePath = "";
                EPUBJS.cssPath = window.location.href.replace(window.location.hash, '').replace('index.html', '') + "css/";

                window.reader = ePubReader(urlEbook);
              }
            };

        $(document).on('click', '.to_read_book', function(){
            $('.read_book').show();
        })

        $(document).on('click', '#no_read_book', function(){
            $('.read_book').hide();
        })

       /* Book.renderTo("area");*/
    }

    if (hasEbook != 0 && isDescription == 0) {
        var Book = ePub({ restore: true });
        Book.open(urlEbook);
        
        Book.getMetadata().then(function(meta){
            var jr_html = '<div class="col-xs-4 col-sm-2 genre_book">Résumé :</div>';
            jr_html    += '<div class="col-xs-8 col-sm-10">' + meta.description + '</div>';

            $.ajax({
                type: 'POST',
                url: $('#description').data('action'),
                async: false,
                data: {
                    id_book: $('#description').data('id_book'),
                    description: meta.description
                },
                success: function(jsonData)
                {
                    $('#description').html(jr_html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });
    }
});