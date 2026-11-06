
        let products = []; // Array para almacenar los productos

        // Mostrar/ocultar formulario para agregar producto (modal emergente)
        document.getElementById('add-product-btn').onclick = function() {
        limpiarFormulario();                                                       
        const addButton = document.querySelector('#add-product-modal .btn');
        addButton.innerText = 'Registrar Producto';                                 // Cambia el texto del botón
        addButton.onclick = function() { addProduct(); };                           // Cambia la acción del botón a agregar
        document.getElementById('add-product-modal').style.display = 'flex';        // Mostrar modal
        };

        document.getElementById('close-modal').onclick = function() {
        document.getElementById('add-product-modal').style.display = 'none'; // Cerrar modal
        resetAddButton(); // Reiniciar botón de agregar
        };

        document.getElementById('report-btn').onclick = function() {
            openReportModal();
        };

        document.getElementById('close-report-modal').onclick = function() {
            document.getElementById('report-modal').style.display = 'none';
        }; 
        
        function openReportModal() {
            const modalList = document.getElementById('report-product-list');
            modalList.innerHTML = '';
            
            Array.from(products).forEach((product, index) => {
                const nombre = product.getElementsByTagName('nombre')[0].textContent;
                
                const item = document.createElement('div');
                item.className = 'report-item';
                item.innerHTML = `
                    <label>
                        <input type="checkbox" id="report-product-${index}" data-index="${index}">
                        ${nombre}
                    </label>
                `;
                modalList.appendChild(item);
            });

            document.getElementById('report-modal').style.display = 'flex';
        }

        document.getElementById('generate-ticket-btn').onclick = function() {
            selectedProducts = Array.from(document.querySelectorAll('#report-product-list input[type="checkbox"]:checked'))
                .map(checkbox => parseInt(checkbox.getAttribute('data-index')));
            
            if (selectedProducts.length > 0) {
                const ticketData = selectedProducts.map(index => {
                    const product = products[index];
                    return {
                        id: product.getElementsByTagName('id')[0].textContent,
                        nombre: product.getElementsByTagName('nombre')[0].textContent,
                        precio: product.getElementsByTagName('precio')[0].textContent,
                        cantidad: product.getElementsByTagName('cantidad')[0].textContent,
                        unidad: product.getElementsByTagName('unidad')[0].textContent,
                    };
                });

                sessionStorage.setItem('ticketData', JSON.stringify(ticketData));
                window.location.href = 'ticket.html';
            } else {
                alert('Seleccione al menos un producto.');
            }
        };


function limpiarFormulario() {
    document.getElementById('nombre').value = '';
    document.getElementById('precio').value = '';
    document.getElementById('cantidad').value = '';
    document.getElementById('unidad').value = 'kilos';
}
function resetAddButton() {
    const addButton = document.querySelector('#add-product-modal .btn');
    addButton.innerText = 'Registrar Producto'; // Restablecer texto
    addButton.onclick = addProduct; // Volver a vincular la función original
}


        // Cargar productos desde la base de datos usando XML
        function cargarProductos() {
            fetch('obtener_productos.php')
            .then(response => response.text())
            .then(str => {
                const parser = new DOMParser();
                const xml = parser.parseFromString(str, "application/xml");
                products = xml.getElementsByTagName('producto');
                const listaProductos = document.getElementById('product-list');
                const noRecordMessage = document.getElementById('no-record-message');

                listaProductos.innerHTML = '';

                if (products.length === 0) {
                    noRecordMessage.style.display = 'block'; // Mostrar mensaje si no hay registros
                } else {
                    noRecordMessage.style.display = 'none'; // Ocultar mensaje si hay registros
                    for (let i = 0; i < products.length; i++) {
                        const nombre = products[i].getElementsByTagName('nombre')[0].textContent;
                        const precio = products[i].getElementsByTagName('precio')[0].textContent;
                        const cantidad = products[i].getElementsByTagName('cantidad')[0].textContent;
                        const unidad = products[i].getElementsByTagName('unidad')[0].textContent;

                        const item = document.createElement('div');
                        item.className = 'product-item';
                        item.innerHTML = `
                            <div class="checkbox-container">
                                <input type="checkbox" id="product-${i}">
                                <strong>${nombre}</strong> - $${parseFloat(precio).toFixed(2)} 
                                <span>(Cantidad: ${cantidad} ${unidad})</span>
                                <button class="edit-btn" onclick="openEditModal(${i})" style="display: none;">Editar</button>
                            </div>
                        `;
                        listaProductos.appendChild(item);
                    }
                }
            })
            .catch(error => {
                console.error('Error al cargar productos:', error);
            });
        }


        // Función para buscar productos
document.getElementById('search-btn').onclick = function() {
    const nombre = document.getElementById('search-nombre').value.toLowerCase();
    const precio = document.getElementById('search-precio').value;
    const unidad = document.getElementById('search-unidad').value;

    // Filtrar los productos basados en los criterios de búsqueda
    const filteredProducts = Array.from(products).filter(product => {
        const prodNombre = product.getElementsByTagName('nombre')[0].textContent.toLowerCase();
        const prodPrecio = product.getElementsByTagName('precio')[0].textContent;
        const prodUnidad = product.getElementsByTagName('unidad')[0].textContent;

        const nombreMatch = nombre ? prodNombre.includes(nombre) : true;
        const precioMatch = precio ? prodPrecio <= precio : true;
        const unidadMatch = unidad ? prodUnidad === unidad : true;

        return nombreMatch && precioMatch && unidadMatch;
    });

    const listaProductos = document.getElementById('product-list');
    listaProductos.innerHTML = ''; // Limpiar lista antes de mostrar resultados

    // Crear los elementos de producto filtrado
    filteredProducts.forEach((product, i) => {
        const nombre = product.getElementsByTagName('nombre')[0].textContent;
        const precio = product.getElementsByTagName('precio')[0].textContent;
        const cantidad = product.getElementsByTagName('cantidad')[0].textContent;
        const unidad = product.getElementsByTagName('unidad')[0].textContent;

        const item = document.createElement('div');
        item.className = 'product-item';
        item.innerHTML = `
            <div class="checkbox-container">
                <input type="checkbox" id="product-${i}">
                <strong>${nombre}</strong> - $${parseFloat(precio).toFixed(2)} 
                <span>(Cantidad: ${cantidad} ${unidad})</span>
                <button class="edit-btn" onclick="openEditModal('${product.getElementsByTagName('id')[0].textContent}')">Editar</button>
            </div>`;
        listaProductos.appendChild(item);
    });

    // Mostrar mensaje si no hay resultados
    document.getElementById('no-record-message').style.display = filteredProducts.length === 0 ? 'block' : 'none';
};


        // Añadir nuevo producto
        function addProduct() {
            const nombre = document.getElementById('nombre').value;
            const precio = document.getElementById('precio').value;
            const cantidad = document.getElementById('cantidad').value;
            const unidad = document.getElementById('unidad').value;

            fetch('agregar_productos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/xml',
                },
                body: `<producto>
                          <nombre>${nombre}</nombre>
                          <precio>${precio}</precio>
                          <cantidad>${cantidad}</cantidad>
                          <unidad>${unidad}</unidad>
                       </producto>`,
            })
            .then(response => response.text())
            .then(result => {
                if (result.includes('<success>true</success>')) {
                    alert('Producto agregado con éxito');
                    resetAddButton(); // Reiniciar botón de agregar
                    document.getElementById('add-product-modal').style.display = 'none'; // Cerrar modal
                    cargarProductos(); // Recargar lista de productos
                    limpiarFormulario(); // Limpiar formulario
                } else {
                    alert('Error al agregar el producto');
                }
            });
        }

        // Limpiar el formulario de agregar producto
        function limpiarFormulario() {
            document.getElementById('nombre').value = '';
            document.getElementById('precio').value = '';
            document.getElementById('cantidad').value = '';
            document.getElementById('unidad').value = 'kilos';
        }

        // Mostrar/Ocultar checkboxes
        document.getElementById('delete-products-btn').onclick = function() {
            const deleteConfirmation = document.getElementById('delete-confirmation');
            const productList = document.getElementById('product-list');

            if (deleteConfirmation.style.display === 'none') {
                deleteConfirmation.style.display = 'flex'; // Mostrar
                productList.querySelectorAll('.checkbox-container').forEach(container => {
                    container.querySelector('input[type="checkbox"]').style.display = 'inline'; // Mostrar checkboxes
                });
            } else {
                deleteConfirmation.style.display = 'none'; // Ocultar
                productList.querySelectorAll('.checkbox-container').forEach(container => {
                    container.querySelector('input[type="checkbox"]').style.display = 'none'; // Ocultar checkboxes
                    container.querySelector('input[type="checkbox"]').checked = false; // Desmarcar
                });
            }
        };

        // Confirmar eliminación de productos seleccionados
        function confirmDeleteProducts() {
            const checkboxes = document.querySelectorAll('.product-item input[type="checkbox"]');
            const idsToDelete = [];

            checkboxes.forEach((checkbox, index) => {
                if (checkbox.checked) {
                    const productId = products[index].getElementsByTagName('id')[0].textContent; // Asegúrate de que el ID esté disponible
                    idsToDelete.push(productId);
                }
            });

            if (idsToDelete.length > 0) {
                fetch('eliminar_productos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/xml',
                    },
                    body: `<productos>${idsToDelete.map(id => `<id>${id}</id>`).join('')}</productos>`,
                })
                .then(response => response.text())
                .then(result => {
                    if (result.includes('<success>true</success>')) {
                        alert('Productos eliminados con éxito');
                        cargarProductos(); // Recargar lista de productos
                    } else {
                        alert('Error al eliminar productos');
                    }
                });
            } else {
                alert('No se seleccionó ningún producto para eliminar.');
            }
        }

        // Función para abrir modal de edición de producto usando el ID del producto
function openEditModal(productId) {
    // Buscar el producto por su ID único
    const product = Array.from(products).find(p => p.getElementsByTagName('id')[0].textContent === productId);
    
    if (!product) {
        alert('Realiza una busqueda para editar');
        return;
    }

    const nombre = product.getElementsByTagName('nombre')[0].textContent;
    const precio = product.getElementsByTagName('precio')[0].textContent;
    const cantidad = product.getElementsByTagName('cantidad')[0].textContent;
    const unidad = product.getElementsByTagName('unidad')[0].textContent;

    // Llenar los campos del formulario con los valores actuales del producto
    document.getElementById('nombre').value = nombre;
    document.getElementById('precio').value = precio;
    document.getElementById('cantidad').value = cantidad;
    document.getElementById('unidad').value = unidad;

    // Cambiar el botón de añadir a un botón de actualizar
    const addButton = document.querySelector('#add-product-modal .btn');
    addButton.innerText = 'Actualizar Producto';
    addButton.onclick = function() {
        updateProduct(productId); // Pasar el ID del producto al actualizar
    };

    // Mostrar el modal
    document.getElementById('add-product-modal').style.display = 'flex';
}

        // Actualizar producto usando su ID
function updateProduct(productId) {
    const nombre = document.getElementById('nombre').value;
    const precio = document.getElementById('precio').value;
    const cantidad = document.getElementById('cantidad').value;
    const unidad = document.getElementById('unidad').value;

    fetch('editar_productos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/xml',
        },
        body: `<producto>
                  <id>${productId}</id>
                  <nombre>${nombre}</nombre>
                  <precio>${precio}</precio>
                  <cantidad>${cantidad}</cantidad>
                  <unidad>${unidad}</unidad>
               </producto>`,
    })
    .then(response => response.text())
    .then(result => {
        if (result.includes('<success>true</success>')) {
            alert('Producto actualizado con éxito');
            resetAddButton(); // Reiniciar botón de agregar
            document.getElementById('add-product-modal').style.display = 'none'; // Cerrar modal
            cargarProductos(); // Recargar lista de productos
        } else {
            alert('Error al actualizar el producto');
        }
    });
}

        // Cargar productos al inicio
        document.addEventListener('DOMContentLoaded', cargarProductos);