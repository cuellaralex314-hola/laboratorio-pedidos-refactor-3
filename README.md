# laboratorio-pedidos

Sistema de gestión de pedidos para un laboratorio de análisis clínicos, desarrollado en PHP vanilla sin framework ni Composer.

## Cómo levantarlo

1. Copiar esta carpeta dentro de `C:\xampp\htdocs\`.
2. Iniciar Apache desde XAMPP.
3. Abrir en el navegador:
   - `http://localhost/mini-proyecto-laboratorio/public/index.php?accion=crear`
   - `http://localhost/mini-proyecto-laboratorio/public/index.php?accion=listar`
   - `http://localhost/mini-proyecto-laboratorio/public/index.php?accion=reporte`

## Configuración

La aplicación arranca sin configurar MySQL. `config/database.php` es opcional
y está ignorado por Git; si no existe, el punto de entrada usa
`config/database.example.php`. La persistencia de esta demo sigue simulada en
memoria, por lo que las operaciones no se conservan al reiniciar PHP.

No agregues credenciales reales al repositorio.

## Patrones aplicados

Se refactorizó el proyecto para reducir la deuda técnica y dejarlo más mantenible:

- Strategy: cálculo de precios por tipo de paciente
- Factory: creación de notificaciones por tipo
- Observer: notificación de eventos de pedido
- Decorator: generación de reportes con agregados encadenables
- Adapter: integración con notificador heredado
- Facade: servicio de pedidos con una API más simple
- MVC: controlador y vista separados de la lógica de negocio

## Acciones disponibles

| URL | Resultado |
|---|---|
| `?accion=crear` | Crea un pedido y lo procesa con validación, cálculo y notificación |
| `?accion=listar` | Muestra la vista de pedidos |
| `?accion=reporte` | Genera un reporte con decoradores |

## Validación rápida

Se puede comprobar el proyecto con PHP embebido local:

```bash
php -S 127.0.0.1:8000 -t C:\xampp\htdocs\mini-proyecto-laboratorio
```

Luego abrir:

```text
http://127.0.0.1:8000/public/index.php?accion=listar
```

## Nota sobre la deuda técnica

El objetivo del ejercicio no fue reescribir toda la aplicación, sino dejarla preparada para cambiar sin miedo. El punto clave es que el descuento de obra social ya no queda repetido en varias capas del sistema; cada decisión quedó centralizada en la estrategia de precios.
