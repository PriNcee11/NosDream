# NosDream: guía para agentes

Aplicación PHP servida por Apache, con MariaDB detrás. El `docker-compose.yml` que
la levanta vive en el repositorio `homelab` (`NosDream-compose.yml`): construye la
imagen desde este directorio, publica el puerto 5007 y arranca un MariaDB 10.11 que
se inicializa con `db/init.sql`.

**Este fichero solo recoge lo que está verificado.** El resto del funcionamiento no
está documentado todavía: averiguarlo leyendo el código, no suponerlo, y apuntar
aquí lo que se confirme.

## Actualizar la copia local antes de tocar nada

`git fetch` **al empezar**: antes de leer código, diagnosticar o planificar, no
al ir a publicar. Si la rama local está por detrás, actualizarla primero y
decirlo. Si hay cambios sin commitear, o la rama ha divergido, decirlo también
en vez de arrastrarlo a ciegas.

No es burocracia: un diagnóstico sobre código viejo puede medir un problema que
ya no existe, o pasar por alto uno nuevo. El 2026-09-20, en `bdo-tracker`, se
trabajaron varias horas sobre una `main` con **6 commits de retraso**; el
trabajo ajeno —que reescribía justo la capa que se estaba optimizando— apareció
al mergear, en forma de conflictos y de mediciones tomadas contra código que ya
estaba sustituido. Estos repositorios tienen trabajo en paralelo.

Al resolver conflictos con trabajo ajeno reciente: conservar su versión y
reaplicar lo propio encima, nunca elegir bando a bulto.

## Trabajo seguro

- La petición del usuario fija el alcance. Un diagnóstico autoriza las lecturas
  necesarias, no una reparación implícita.
- No leer `.env`, credenciales, volcados de la base real ni registros personales
  salvo que la tarea lo pida y el usuario lo autorice.
- Las credenciales del compose (`nosdream`/`nosdream`, `rootpass`) son de
  desarrollo. No darlas por buenas en producción ni copiarlas a ningún sitio.
- Trabajar con datos inventados. No abrir ni copiar la base de producción.
- Este código es PHP sin framework y con entrada de usuario (`login.php`,
  `insertar_*.php`, `borrar_item.php`): al tocarlo, mirar inyección SQL y salida
  sin escapar antes que la estética.
