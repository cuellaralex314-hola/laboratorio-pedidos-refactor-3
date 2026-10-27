# Deuda técnica y patrones aplicados

| Síntoma observado | Evidencia (archivo:línea) | Tipo de deuda | Patrón aplicado | Consecuencia asumida |
|---|---|---|---|---|
| El código cargaba clases con `require` manuales y no era extensible | `public/index.php:2-30` | Proceso | Autoload + configuración externa | Requiere estructura inicial más clara, pero evita romper el proyecto al agregar archivos |
| Las credenciales de la BD estaban versionadas en el repositorio | `public/index.php:26-31` | Proceso | Configuración externa | Se depende de un archivo local que no forma parte del historial |
| El ruteo se resolvía con una cadena de `if` | `public/index.php:33-39` | Diseño | Tabla de rutas | El mapa de rutas agrega un pequeño costo de inicialización |
| El descuento de obra social estaba repetido en varias capas | `src/Models/Order.php:41-53`, `src/Pricing/PriceCalculator.php:14-70`, `src/Services/OrderService.php:31-42`, `src/Controllers/OrderController.php:14-19`, `views/orders.php:28-36` | Diseño | Strategy | Agrega 3 clases y una interfaz nueva para evitar el `switch` y el hardcode |
| Las notificaciones dependían de `if` por tipo y clases concretas | `src/Notifications/NotificationSender.php:1-29` | Diseño | Factory | Hay una capa extra de creación que requiere acordar nombres y contratos |
| Los avisos se ejecutaban en cadena desde el sujeto, acoplado a clases concretas | `src/Events/OrderEvents.php:1-38` | Diseño | Observer | El flujo de eventos queda menos explícito en el código que el llamado directo |
| El reporte usaba banderas booleanas y combinaciones difíciles de leer | `src/Reports/ReportGenerator.php:1-40` | Diseño | Decorator | El orden de los decoradores importa, y eso exige documentación y convención |
| El servicio de pedidos mezclaba validación, cálculo, persistencia y presentación | `src/Services/OrderService.php:1-52` | Diseño | Facade | La fachada centraliza la lógica, pero también puede esconder complejidad si crece demasiado |
| El controlador mezclaba entrada, negocio, SQL y HTML | `src/Controllers/OrderController.php:1-35` | Diseño | MVC + SRP | El controlador queda más delgado, pero necesita que el servicio lo haga todo bien |
| La vista consultaba datos y calculaba descuentos | `views/orders.php:1-33` | Diseño | MVC | La vista se vuelve más simple, pero necesita que el controlador le dé todo preparado |
| El sistema heredado se integraba con copia y pega de código ajeno | `src/Legacy/LegacyNotifier.php:1-20` | Diseño | Adapter | Introduce una capa de traducción que puede parecer redundante para casos simples |
| La conexión se creaba repetidamente y la excepción se ignoraba | `src/Database/Connection.php:1-38` | Diseño | Singleton | El uso global de una sola instancia puede ocultar problemas de concurrencia si el proyecto crece |
