# Mini Buscador de Páginas Web

Este proyecto consiste en una página web que funge como buscador de otras páginas web que se ingresan a través de este mismo, de manera que le permite al usuario visualizar, añadir y buscar páginas dentro de una sola.
A continuación, se describen algunas de las funcionalidades principales:
1. Añadir páginas web a la base de datos del buscador.
2. Ver todas las páginas almacenadas dentro del buscador.
3. Actualizar la información de las páginas que se encuentran en la base de datos.
4. Añadir nuevas páginas web en base a las que ya han sido almacenadas.
5. Buscar páginas que coincidan con la palabra ingresada.

#### Carpetas Principales de este Repositorio
* **rssNews:** Esta carpeta contiene el "antiguo" proyecto, el cual fue la base para la evolución del mismo; Consiste en un visualizador de noticias RSS (.xml) utilizando la librería SimplePie de PHP.
* **mini-browser:** Esta carpeta es la versión final del proyecto, la cual consiste en la página web mencionada anteriormente que, finalmente, permite visualizar páginas web utilizando web scrapping y funciones php para ejecutarse.
* **versionOptimizada:** Esta carpeta contiene la versión optimizada del proyecto final, durante esta versión se aplicaron modificaciones del lado del cliente y del servidor, como la aplicación del módulo de comprensión gzip en xampp, caché en php y optimización en archivos html, jpg, etc.

### Pre-requisitos

Para la versión final del proyecto, se necesitará añadir una carpeta de Bootstrap al directorio raíz, es decir, en la misma dirección que el .gitignore; la versión que utilizamos de dicha carpeta fue la 4.3.1. De igual forma, deberá de añadirse (en el mismo directorio raíz) un archivo JSON con la información de la base de datos local para que las conexiones a la misma puedan realizarse.

_Ejemplo del archivo JSON:_

```
{
  "host": "nombre del host",
  "user": "nombre del usuario para la base de datos local",
  "password": "contraseña de la base de datos local",
  "database": "nombre de la base de datos que se utilizará"
}
```

Puesto que el proyecto final tomó un curso diferente, no se pretende dar una explicación extensiva del proyecto "original" que incluye el uso de rss, pero puede consultarse el siguiente enlace para comprender cómo funciona y tener una idea más clara:
- [Consumin feeds with SimplePie](https://www.sitepoint.com/consuming-feeds-with-simplepie/)

### Herramientas utilizadas

* **Bootstrap** - Biblioteca (css/js) multiplataforma para el diseño de sitios y aplicaciones web.
* **Xampp** - Es un software libre que te permite gestionar bases de datos MySQL, el servidor web Apache y lenguajes del lado del servidor como PHP, Perl, etc.

**Nota:** Para la versión 2 de este proyecto se realizaron configuraciones en el servidor con el fin de optimizar el buscador, a continuación se enlistan algunos enlaces que resultaron útiles:
- [How to enable gzip compression in Xampp Server](https://ourcodeworld.com/articles/read/503/how-to-enable-gzip-compression-in-xampp-server)
- [Foro: Gzip compression in Xampp Server](https://stackoverrun.com/es/q/1772135)
- [How to enable Gzip compression in Apache](https://knackforge.com/blog/karalmax/how-enable-gzip-compression-apache)

## Autores
* **José Luis Ávila Vela** - [avilavela](https://github.com/avilavela)
* **Itzel Carolina Bermúdez Burgos** - [flopYtzel](https://github.com/flopYtzel)
* **Naomi García Sánchez** - [GreenNugget](https://github.com/GreenNugget)