<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("conexion.php");
$usuario_id = $_SESSION['usuario_id'];

// Obtener correo y teléfono guardados en el registro (tablas usuarios y contactos)
$query = "SELECT u.nombre_usuario, c.correo, c.telefono FROM usuarios u LEFT JOIN contactos c ON u.id = c.usuario_id WHERE u.id = '$usuario_id'";
$resultado = mysqli_query($conex, $query);
$userData = mysqli_fetch_assoc($resultado);

$correo_db = $userData['correo'] ?? '';
$telefono_db = $userData['telefono'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agrono-mmerce - Confirmación y Seguimiento</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <link rel="stylesheet" href="style_rec.css">
  <link rel="stylesheet" href="home_style.css">
  <link rel="stylesheet" href="style_modal.css">
  <link rel="stylesheet" href="style_rec2.css">
  
  <!-- SDK oficial de PayPal -->
  <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=MXN"></script>

  <style>
    :root {
      --header-bg: #2b2e2b;
      --brand-green: #388e3c;
      --dark-green: #1b5e20;
      --light-green: #e8f5e9;
      --bg-color: #f4f6f8;
      --card-bg: #ffffff;
      --text-dark: #212121;
      --text-muted: #666666;
      --border-color: #dddddd;
      --paypal-blue: #0070ba;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
    body { background-color: var(--bg-color); color: var(--text-dark); padding-bottom: 50px; }

    .agronomex-navbar {
      background-color: var(--header-bg);
      color: #ffffff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .agronomex-brand-area { display: flex; align-items: center; gap: 20px; }
    .agronomex-brand { display: flex; align-items: center; gap: 12px; }
    .agronomex-brand img { height: 45px; width: auto; object-fit: contain; }
    .agronomex-brand h1 { font-size: 1.4rem; letter-spacing: 2px; font-weight: 700; color: #ffffff; }
    .agronomex-brand span { font-size: 0.85rem; color: #a5d6a7; }

    /* Estilo para el botón Volver al Carrito junto al logo */
    .btn-volver-carrito {
      background-color: rgba(255, 255, 255, 0.12);
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.25);
      padding: 7px 14px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
      transition: background 0.2s, border-color 0.2s;
    }
    .btn-volver-carrito:hover {
      background-color: var(--brand-green);
      border-color: var(--brand-green);
      color: #fff;
    }

    .checkout-container { max-width: 800px; margin: 30px auto; padding: 0 15px; }
    .checkout-card { background: var(--card-bg); border-radius: 10px; padding: 25px 30px; margin-bottom: 25px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.04); }

    .section-head { font-size: 1.15rem; color: var(--dark-green); margin-bottom: 18px; border-bottom: 2px solid var(--brand-green); padding-bottom: 8px; display: flex; align-items: center; justify-content: space-between; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .span-2 { grid-column: span 2; }
    .field { display: flex; flex-direction: column; gap: 5px; }
    .field label { font-size: 0.85rem; font-weight: 600; color: #444; }
    .field input, .field select, .field textarea { padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; outline: none; }
    
    /* Checkbox Facturación */
    .facturacion-box { background: #f9f9f9; border: 1px dashed var(--brand-green); padding: 15px; border-radius: 8px; margin-top: 15px; display: none; }
    .facturacion-box.active { display: block; }

    .order-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .order-table th, .order-table td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; font-size: 0.9rem; }
    .order-totals { margin-top: 15px; border-top: 2px solid #333; padding-top: 12px; }
    .row-total { display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 0.95rem; }
    .row-total.final { font-size: 1.2rem; font-weight: bold; color: var(--dark-green); margin-top: 10px; }

    .badge-envio { background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 4px; font-size: 0.78rem; font-weight: 600; }

    /* Estilos para Folio y Código de Rastreo */
    .tracking-box {
      background: #f1f8e9;
      border: 2px dashed var(--brand-green);
      border-radius: 8px;
      padding: 15px 20px;
      margin: 20px 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      text-align: center;
    }
    .tracking-item h5 { font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; }
    .tracking-item span { font-size: 1.1rem; font-weight: bold; color: var(--dark-green); font-family: monospace; }

    @media print {
      .no-print, .agronomex-navbar { display: none !important; }
      #step-2-ticket { display: block !important; }
      body { background: #fff; }
    }
  </style>
</head>
<body>

  <!-- Barra Superior con Botón de Retorno al Carrito -->
  <div class="agronomex-navbar">
    <div class="agronomex-brand-area">
      <div class="agronomex-brand">
        <img src="Imagenes/WhatsApp_Image_2024-06-17_at_9.00.39_PM-removebg-preview.png" alt="Logo Agronomex">
        <div>
          <h1>AGRONO-MMERCE</h1>
          <span>Transformando el campo</span>
        </div>
      </div>
      <!-- Botón añadido al lado del logo -->
      <a href="recibo.php" class="btn-volver-carrito no-print">
        <i class="fas fa-arrow-left"></i> Volver al Carrito
      </a>
    </div>

    <div style="font-size: 0.85rem; color: #ccc;" class="no-print">
      <i class="fas fa-shield-alt"></i> Sesión: <?php echo htmlspecialchars($_SESSION['usuario']); ?>
    </div>
  </div>

  <div class="checkout-container">

    <!-- ================= PASO 1: FORMULARIO DE ENVÍO Y PAGO ================= -->
    <div id="step-1-checkout" class="no-print">
      <form id="agronomex-form" onsubmit="event.preventDefault();">
        
        <!-- DATOS DE ENVÍO -->
        <div class="checkout-card">
          <div class="section-head">
            <span><i class="fas fa-truck-ramp-box"></i> 1. Dirección de Entrega y Envío</span>
            <span class="badge-envio"><i class="fas fa-shipping-fast"></i> Envíos a todo México</span>
          </div>

          <div class="grid-2">
            <div class="field">
              <label for="cli-nombre">Nombre(s) del destinatario *</label>
              <input type="text" id="cli-nombre" placeholder="Ej. Jorge Alberto" required>
            </div>
            <div class="field">
              <label for="cli-apellidos">Apellidos *</label>
              <input type="text" id="cli-apellidos" placeholder="Ej. Vázquez Rojas" required>
            </div>
            <div class="field span-2">
              <label for="cli-direccion">Calle, Número exterior e interior *</label>
              <input type="text" id="cli-direccion" placeholder="Ej. Av. Miguel Hidalgo #402" required>
            </div>
            <div class="field">
              <label for="cli-colonia">Colonia / Ejido / Rancho *</label>
              <input type="text" id="cli-colonia" placeholder="Ej. Centro" required>
            </div>
            <div class="field">
              <label for="cli-cp">Código Postal *</label>
              <input type="text" id="cli-cp" maxlength="5" placeholder="66600" required>
            </div>
            <div class="field">
              <label for="cli-ciudad">Ciudad / Municipio *</label>
              <input type="text" id="cli-ciudad" placeholder="Ej. Apodaca" required>
            </div>
            <div class="field">
              <label for="cli-estado">Estado *</label>
              <select id="cli-estado" required>
                <option value="Nuevo León" selected>Nuevo León</option>
                <option value="Coahuila">Coahuila</option>
                <option value="Tamaulipas">Tamaulipas</option>
                <option value="Jalisco">Jalisco</option>
                <option value="Otro">Otro Estado...</option>
              </select>
            </div>
            <!-- Autocompletado con datos de la BD -->
            <div class="field">
              <label for="cli-telefono">Teléfono de Contacto *</label>
              <input type="tel" id="cli-telefono" maxlength="10" value="<?php echo htmlspecialchars($telefono_db); ?>" placeholder="Ej. 8112293549" required>
            </div>
            <div class="field span-2">
              <label for="cli-correo">Correo Electrónico *</label>
              <input type="email" id="cli-correo" value="<?php echo htmlspecialchars($correo_db); ?>" placeholder="correo@ejemplo.com" required>
            </div>
          </div>

          <!-- MÓDULO DE FACTURACIÓN -->
          <div style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
            <button type="button" onclick="toggleFacturacion()" style="background: #f0f0f0; border: 1px solid #ccc; padding: 10px 15px; border-radius: 6px; cursor: pointer; font-weight: 600; color: #333;">
              <i class="fas fa-file-invoice-dollar" style="color: var(--brand-green);"></i> ¿Ocupas facturación?
            </button>

            <div id="facturacion-section" class="facturacion-box">
              <h4 style="color: var(--dark-green); margin-bottom: 10px; font-size: 1rem;"><i class="fas fa-receipt"></i> Datos Fiscales para Factura</h4>
              <div class="grid-2">
                <div class="field">
                  <label>RFC *</label>
                  <input type="text" id="fac-rfc" placeholder="XAXX010101000">
                </div>
                <div class="field">
                  <label>Razón Social *</label>
                  <input type="text" id="fac-razon" placeholder="Nombre o Empresa S.A. de C.V.">
                </div>
                <div class="field">
                  <label>Uso de CFDI *</label>
                  <select id="fac-cfdi">
                    <option value="G03">G03 Gastos en general</option>
                    <option value="G01">G01 Adquisición de mercancías</option>
                    <option value="P01">P01 Por definir</option>
                  </select>
                </div>
                <div class="field">
                  <label>Régimen Fiscal *</label>
                  <select id="fac-regimen">
                    <option value="601">601 General de Ley Personas Morales</option>
                    <option value="612">612 Personas Físicas con Actividades Empresariales</option>
                    <option value="626">626 Régimen Simplificado de Confianza (RESICO)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- PAGO CON PAYPAL -->
        <div class="checkout-card">
          <div class="section-head">
            <span><i class="fab fa-paypal" style="color: var(--paypal-blue);"></i> 2. Pago Seguro con PayPal</span>
          </div>
          <p style="font-size: 0.9rem; color: #555; margin-bottom: 20px;">
            Liquida tu pedido de insumos de forma segura. Al aprobarse el pago, se generará tu folio y código de rastreo automático.
          </p>
          <div id="paypal-button-container" style="max-width: 400px; margin: 0 auto;"></div>
        </div>
      </form>
    </div>


    <!-- ================= PASO 2: PANTALLA DE FOLIO, RASTREO Y TICKET ================= -->
    <div id="step-2-ticket" style="display: none;">
      <div class="checkout-card" style="border-top: 5px solid var(--dark-green);">
        <div style="text-align: center; padding-bottom: 15px; border-bottom: 2px dashed #ccc;">
          <h2 style="color: var(--dark-green);"><i class="fas fa-check-circle" style="color: var(--brand-green);"></i> ¡Pedido Exitoso!</h2>
          <p style="font-size: 0.9rem; color: #666; margin-top: 4px;">Gracias por tu compra en AGRONO-MMERCE</p>
        </div>

        <!-- RECUADRO DE FOLIO Y CÓDIGO DE RASTREO -->
        <div class="tracking-box">
          <div class="tracking-item">
            <h5>Folio de Pedido</h5>
            <span id="out-folio" style="color: var(--dark-green);">AGR-98421</span>
          </div>
          <div style="width: 1px; background: #c8e6c9; height: 40px;"></div>
          <div class="tracking-item">
            <h5>Código de Rastreo (Guía)</h5>
            <span id="out-rastreo" style="color: #e65100;">MX-TRK-77392</span>
          </div>
        </div>

        <div style="background: #e8f5e9; padding: 12px 15px; border-radius: 4px; margin-bottom: 20px;">
          <h4 style="margin-bottom: 6px; color: var(--dark-green); font-size: 0.95rem;"><i class="fas fa-truck"></i> Información de Envío Asignada</h4>
          <p style="font-size: 0.88rem; margin: 2px 0;"><strong>Destinatario:</strong> <span id="out-nombre"></span></p>
          <p style="font-size: 0.88rem; margin: 2px 0;"><strong>Dirección:</strong> <span id="out-direccion"></span></p>
          <p style="font-size: 0.88rem; margin: 2px 0;"><strong>Ubicación:</strong> <span id="out-ubicacion"></span></p>
          <p style="font-size: 0.88rem; margin: 2px 0;"><strong>Teléfono:</strong> <span id="out-telefono"></span></p>
        </div>

        <h4><i class="fas fa-boxes-packing"></i> Resumen de Productos</h4>
        <table class="order-table">
          <thead>
            <tr>
              <th>Cant. / Unidad</th>
              <th>Producto</th>
              <th style="text-align: right;">Precio Unit.</th>
              <th style="text-align: right;">Subtotal</th>
            </tr>
          </thead>
          <tbody id="ticket-content"></tbody>
        </table>

        <div class="order-totals">
          <div class="row-total">
            <span>Subtotal:</span>
            <span id="subtotal-val">$0.00</span>
          </div>
          <div class="row-total">
            <span>Envío a domicilio:</span>
            <span id="envio-val">$50.00</span>
          </div>
          <div class="row-total final">
            <span>Total Pagado (PayPal):</span>
            <span id="total-val">$0.00</span>
          </div>
        </div>

        <div class="no-print" style="display: flex; gap: 10px; margin-top: 25px;">
          <button onclick="window.print()" style="background:#388e3c; color:#fff; border:none; padding:12px; border-radius:6px; font-weight:bold; cursor:pointer; flex:1;">
            <i class="fas fa-print"></i> Imprimir Comprobante / Guía
          </button>
          <button onclick="location.href='recibo.php'" style="background:#757575; color:#fff; border:none; padding:12px; border-radius:6px; font-weight:bold; cursor:pointer; flex:1;">
            <i class="fas fa-arrow-left"></i> Volver a la Tienda
          </button>
        </div>
      </div>
    </div>

  </div>

  <script>
    let facturaActiva = false;

    function toggleFacturacion() {
      facturaActiva = !facturaActiva;
      const box = document.getElementById('facturacion-section');
      box.classList.toggle('active', facturaActiva);

      const inputs = box.querySelectorAll('input');
      inputs.forEach(i => {
        if (facturaActiva) i.setAttribute('required', 'true');
        else i.removeAttribute('required');
      });
    }

    function calcularTotalPagar() {
      let ticketData = [];
      try { ticketData = JSON.parse(sessionStorage.getItem('ticketData') || '[]'); } catch (e) {}
      let subtotal = 0;
      ticketData.forEach(p => { subtotal += parseFloat(p.precio || 0) * parseInt(p.cantidad || 1); });
      return (subtotal > 0 ? subtotal + 50.00 : 50.00).toFixed(2);
    }

    // Botón PayPal
    paypal.Buttons({
      createOrder: function(data, actions) {
        const nombre = document.getElementById('cli-nombre').value;
        const direccion = document.getElementById('cli-direccion').value;
        const cp = document.getElementById('cli-cp').value;
        const ciudad = document.getElementById('cli-ciudad').value;
        const telefono = document.getElementById('cli-telefono').value;
        const correo = document.getElementById('cli-correo').value;

        if (!nombre || !direccion || !cp || !ciudad || !telefono || !correo) {
          alert("Por favor completa todos los campos obligatorios de envío.");
          throw new Error("Campos incompletos");
        }

        return actions.order.create({
          purchase_units: [{ amount: { value: calcularTotalPagar() } }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          guardarDatosEnBDAndShowTicket(details);
        });
      }
    }).render('#paypal-button-container');

    function guardarDatosEnBDAndShowTicket(paypalDetails) {
      const formData = {
        nombre: document.getElementById('cli-nombre').value + ' ' + document.getElementById('cli-apellidos').value,
        direccion: document.getElementById('cli-direccion').value,
        colonia: document.getElementById('cli-colonia').value,
        cp: document.getElementById('cli-cp').value,
        ciudad: document.getElementById('cli-ciudad').value,
        estado: document.getElementById('cli-estado').value,
        telefono: document.getElementById('cli-telefono').value,
        correo: document.getElementById('cli-correo').value,
        req_factura: facturaActiva ? 1 : 0,
        rfc: facturaActiva ? document.getElementById('fac-rfc').value : '',
        razon_social: facturaActiva ? document.getElementById('fac-razon').value : '',
        uso_cfdi: facturaActiva ? document.getElementById('fac-cfdi').value : '',
        regimen_fiscal: facturaActiva ? document.getElementById('fac-regimen').value : ''
      };

      fetch('guardar_envio.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
      }).catch(err => console.error("Error al sincronizar envío con BD:", err));

      generarFolioYRastreo();
    }

    function generarFolioYRastreo() {
      const randomNum1 = Math.floor(10000 + Math.random() * 90000);
      const randomNum2 = Math.floor(100000 + Math.random() * 900000);
      const folioUnico = `AGR-${randomNum1}`;
      const codigoRastreo = `MX-AGRO-${randomNum2}`;

      document.getElementById('out-folio').textContent = folioUnico;
      document.getElementById('out-rastreo').textContent = codigoRastreo;

      document.getElementById('out-nombre').textContent = document.getElementById('cli-nombre').value + ' ' + document.getElementById('cli-apellidos').value;
      document.getElementById('out-direccion').textContent = document.getElementById('cli-direccion').value + ', Col. ' + document.getElementById('cli-colonia').value;
      document.getElementById('out-ubicacion').textContent = document.getElementById('cli-ciudad').value + ', ' + document.getElementById('cli-estado').value + ' (C.P. ' + document.getElementById('cli-cp').value + ')';
      document.getElementById('out-telefono').textContent = document.getElementById('cli-telefono').value;

      let ticketData = [];
      try { ticketData = JSON.parse(sessionStorage.getItem('ticketData') || '[]'); } catch (e) {}

      const ticketContent = document.getElementById('ticket-content');
      ticketContent.innerHTML = '';
      let subtotalGeneral = 0;

      ticketData.forEach(prod => {
        const precioUnit = parseFloat(prod.precio || 0);
        const cantidad = parseInt(prod.cantidad || 1);
        const subtotalItem = precioUnit * cantidad;
        subtotalGeneral += subtotalItem;

        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${cantidad} ${prod.unidad || 'pzas'}</td>
          <td><strong>${prod.nombre || 'Producto'}</strong></td>
          <td style="text-align: right;">$${precioUnit.toFixed(2)}</td>
          <td style="text-align: right;">$${subtotalItem.toFixed(2)}</td>
        `;
        ticketContent.appendChild(tr);
      });

      const totalPagar = subtotalGeneral + 50.00;
      document.getElementById('subtotal-val').textContent = `$${subtotalGeneral.toFixed(2)}`;
      document.getElementById('envio-val').textContent = `$50.00`;
      document.getElementById('total-val').textContent = `$${totalPagar.toFixed(2)}`;

      document.getElementById('step-1-checkout').style.display = 'none';
      document.getElementById('step-2-ticket').style.display = 'block';
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  </script>
</body>
</html>