import './bootstrap';

    $(document).ready(function(){
        $('.nav-cart').hover(function(){
            $('.cart').show();
        }, function(){
            $('.cart').hide();
        });
    });
