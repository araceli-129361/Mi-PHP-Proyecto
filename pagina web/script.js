
document.addEventListener('DOMContentLoaded', () => {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const botonesAgregar = document.querySelectorAll('.agregar-carrito');
    const listaCarrito = document.getElementById('lista-carrito');
    const vaciarBtn = document.getElementById('vaciar-carrito');

    function actualizarCarrito() {
        listaCarrito.innerHTML = '';
        carrito.forEach((producto, index) => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td><img src="images/${producto.imagen}" width="50"></td>
                <td>${producto.nombre}</td>
                <td>$${producto.precio}</td>
                <td><button class="borrar" data-index="${index}">X</button></td>
            `;
            listaCarrito.appendChild(fila);
        });
        localStorage.setItem('carrito', JSON.stringify(carrito));
    }

    botonesAgregar.forEach((boton) => {
        boton.addEventListener('click', (e) => {
            const tarjeta = boton.closest('.ofert-1');
            const nombre = tarjeta.querySelector('.product-txt h3').textContent;
            const precio = tarjeta.querySelector('.precio').textContent.replace('$', '');
            const imagen = tarjeta.querySelector('img').getAttribute('src').replace('images/', '');

            carrito.push({ nombre, precio, imagen });
            actualizarCarrito();
            alert('Producto agregado al carrito');
        });
    });

    listaCarrito.addEventListener('click', (e) => {
        if (e.target.classList.contains('borrar')) {
            const index = e.target.getAttribute('data-index');
            carrito.splice(index, 1);
            actualizarCarrito();
        }
    });

    vaciarBtn.addEventListener('click', () => {
        carrito.length = 0;
        actualizarCarrito();
    });

    actualizarCarrito(); 
});
