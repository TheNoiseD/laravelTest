const cartPill = $('.pill-card')

$('.add-to-cart').click(function (e) {
    e.preventDefault()
    let id = $(this).data('product-id')

    axios.post('/cart',{
        id: id
    })
    .then(function (response) {
        console.log(response.data.cart_qty)
        cartPill.text(response.data.cart_qty)
    })
    .catch(function (error) {
        if (error.response.status === 401) {
            alert('Debes iniciar sesión para agregar productos a tu carrito')
            window.location.href = '/login'
        }
    })
})
