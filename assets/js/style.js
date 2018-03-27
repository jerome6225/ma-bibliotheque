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
});