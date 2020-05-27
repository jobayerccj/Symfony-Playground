$(document).ready(function(){
    console.log('testing document loading');
    $('.js-user-autocomplete').each(function(){

        var autoCompleteUrl = $(this).data('autocomplete-url');

        $('.js-user-autocomplete').autocomplete({hint:false},[
            {
                source: function(query, cb){
    
                    $.ajax({
                        url: autoCompleteUrl + '?query='+ query
                    }).then(function(data){
                        cb(data.users)
                    });
                    
                },
                displayKey: 'email',
                debounce: 500
            }
            
        ]);
    });

    

});