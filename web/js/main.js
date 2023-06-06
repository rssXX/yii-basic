function addCart(id_product){
    $.ajax({
        method: "GET",
        url: `/web/cart/create?id_product=${id_product}`,
    }).done(function (message){
        $.pjax.reload({
            container: `#cart`
        })
        $('.info').html(message)
    })
}

function removeCart(id_product){
    $.ajax({
        method: "POST",
        url: `cart/delete?id_product=${id_product}`,
    }).done(function (message){
        $.pjax.reload({
            container: `#cart`
        })
        $('.info').html(message)
    })
}

function byOrder(){
    let password = $('#inputPassword5').val();
    if (!password){
        $('.info').html("Укажите пароль");
    }else{
        $.ajax({
            method: "GET",
            url: `cart/by-order?password=${password}`,
        }).done(function (message){
            $.pjax.reload({
                container: `#cart`
            })
            $('.info').html(message);
        })
    }
}

function getProduct(id_category){
    $.pjax.reload({
        url: `/?id_category=${id_category}`,
        container: '#cart'
    })
}