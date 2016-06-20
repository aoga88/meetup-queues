![](logo.png)
#Manejo de Colas con PHP
##SinDelantal.mx / Junio 2016

Osvaldo García <osvaldo.garcia@sindelantal.mx>
Héctor Gutierrez <hector.gutierrez@sindelantal.mx>

<font color="red">*Nota: Para cuestiones del ejemplo usaremos soluciones opensource, de modo que todos los puedan replicar sin problemas.*</font>

## ¿Para qué son las colas de mensajes?
Las colas de mensajes nos ayudan a:

* Eliminar la dependencia entre sistemas, dos sistemas pueden ser totalmente independiente uno del otro, incluso estar en distintos lenguajes de programación y tener comunicación a través de una cola de mensajes.
* Mejorar el rendimiento de un sistema a través del procesamiento asíncrono.

## Procesamiento Asíncrono de Tareas
En [SinDelantal](https://sindelantal.mx) hacemos uso de esta tecnología para aprovechar el procesamiento asíncrono de tareas, de esta manera reducir la carga de servidores y poder atender todos los pedidos que recibimos.

## Ejemplo
Imagina que en cada pedido que se recibe necesitamos mandar un correo electrónico confirmando la recepción del mismo, pero el envio del correo depende de un servicio externo.

### Puntos a considerar
1. El correo no es fundamental para procesar la orden, por lo que si llega un momento despues no pasa nada.
2. No estamos seguros de que el servicio externo no vaya a fallar, porque lo que no podemos dejar el envio directamente en el mismo segmento de código del pedido, si el proveedor llega a fallar puede ocasionar que no logremos procesar pedidos.
3. No queremos retrasar la respuesta del usuario.

### ¿Cómo lo resolvemos?
El proceso es muy simple:

1. Un programa va a escribir mensajes en el sistema de colas (Publisher).
2. El sistema de colas los recibe, RabbitMQ en nuestro caso (Broker).
3. Un segundo programa va a estar leyendo los mensajes(Consumer) y ejecutando alguna acción dependiendo del mensaje recibido.

### ¿Qué necesitamos?
* Vagrant
* PHP instalado (Obvio xD)
* Ansible
* [Publisher](src/publisher.php)
* [Consumer](src/consumer.php)

## Preguntas y Respuestas