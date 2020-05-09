$(document).ready(function(){
    $(document).on('click', '.js-like-article', function(e){
        e.preventDefault();

        $link = $(e.currentTarget);
        $link.toggleClass('fa-heart-o').toggleClass('fa-heart');

        //$('.js-like-article-count').html('Test');

        $.ajax({
            method:"POST",
            url: $link.attr('href')
        }).done(function(data){
           
            $('.js-like-article-count').html(data.hearts);
        });
    })
});