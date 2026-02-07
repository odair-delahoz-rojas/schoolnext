# Resumen del Proyecto

SchoolNext es una aplicación web para la gestión escolar en Colombia, construida sobre el framework KumbiaPHP. Proporciona una solución integral para la gestión de diversos aspectos de una escuela, incluyendo estudiantes, padres, profesores, calificaciones y más.

## Tecnologías Clave

*   **Backend:** KumbiaPHP v1.2 (PHP 7.4+)
*   **Base de datos:** MySQL
*   **Frontend:** AdminLTE4, HTMX 2.x, jQuery, JavaScript puro
*   **Gestión de Dependencias:** Composer para PHP

## Arquitectura

El proyecto sigue una arquitectura estándar Modelo-Vista-Controlador (MVC):

*   **Modelos:** Ubicados en `frontend/app/models`, representan la estructura de datos y la lógica de negocio de la aplicación.
*   **Vistas:** Ubicadas en `frontend/app/views`, se encargan de la capa de presentación, utilizando el motor de plantillas AdminLTE.
*   **Controladores:** Ubicados en `frontend/app/controllers`, gestionan la entrada del usuario, interactúan con los modelos y seleccionan la vista adecuada para renderizar.

La aplicación está estructurada con una clara separación de responsabilidades e incluye un sistema de control de acceso basado en roles (RBAC), con diferentes controladores para varios roles de usuario como administradores, coordinadores, profesores, padres y secretarias.

# Análisis Detallado (por Gemini)

## Resumen Ejecutivo

*   **Proyecto:** SchoolNext, una aplicación web multi-inquilino para la gestión escolar.
*   **Framework:** KumbiaPHP v1.2, con una base de código personalizada.
*   **Arquitectura:** Patrón Modelo-Vista-Controlador (MVC) clásico, con una clara separación entre el núcleo del framework (`core1.2`) y la lógica de la aplicación (`frontend`).

## Configuración y Arranque

*   **Punto de Entrada:** `frontend/public/index.php` es el archivo principal. **Advertencia crítica: Contiene rutas absolutas hardcodeadas que DEBEN ser actualizadas para que la aplicación funcione en cualquier otro entorno.**
*   **Configuración de Base de Datos:** Se gestiona en `frontend/app/config/databases.php`, soportando múltiples instituciones (tenants).
*   **Mapeo de Tablas:** Los nombres de tablas lógicos utilizados en el código (ej. `estudiante`) se mapean a nombres de tablas físicos en la base de datos (ej. `sweb_estudiantes`) a través de `frontend/app/config/tablas.php`.

## Implementación MVC

### Modelos

*   Ubicados en `frontend/app/models`.
*   Extienden una clase `LiteRecord` personalizada y utilizan un potente constructor de consultas `OdaDql` para generar sentencias SQL complejas.
*   Organizados mediante traits de PHP, lo que permite la modularidad y evita que los archivos de modelo sean excesivamente grandes.
*   Incluyen métodos específicos para diferentes roles de usuario (ej. `getListSecretaria`, `getListPorProfesor`), lo que refleja la arquitectura basada en roles de la aplicación.

### Vistas

*   Situadas en `frontend/app/views`.
*   Son archivos `.phtml` que combinan HTML y PHP.
*   Utilizan clases de ayuda como `OdaTable` y `View` para renderizar elementos comunes de la interfaz de usuario.
*   Es común que las vistas llamen directamente a métodos de los objetos del modelo para obtener datos y lógica de presentación (ej. enlaces HTML).

### Controladores

*   Ubicados en `frontend/app/controllers`.
*   Orquestan el flujo de la aplicación, interactuando con los modelos para obtener datos y luego pasándolos a las vistas para su renderización.
*   El enrutamiento se basa en convenciones (ej. `/matriculas/index` se mapea a `MatriculasController::index()`).

## Gestión de Assets Frontend

*   Los assets (CSS, JS, imágenes) se gestionan mediante un script PHP (`frontend/bin/publish.php`) que copia archivos desde el directorio `vendor` al directorio `public`. Este script se ejecuta automáticamente como parte del `composer install`.

## Base de Datos

*   No se encontró un archivo de esquema de base de datos `.sql`. Sin embargo, el archivo `frontend/app/config/tablas.php` proporciona un mapeo claro de los nombres lógicos a los nombres físicos de las tablas, lo cual es fundamental para entender la estructura de la base de datos.

---

# Construcción y Ejecución

## Configuración del Backend

1.  **Servidor Web:** Configure un servidor web (por ejemplo, Apache, Nginx) con PHP 7.4 o superior.
2.  **Raíz del Documento:** Configure la raíz del documento del servidor web para que apunte al directorio `frontend/public`.
3.  **Base de Datos:**
    *   Cree una base de datos MySQL.
    *   Configure la conexión a la base de datos en `frontend/app/config/databases.php`. La configuración principal es `windsor`.
    *   **Información Adicional:** Aunque no se ha encontrado un esquema SQL directo, el archivo `frontend/app/config/tablas.php` contiene un mapeo de nombres lógicos a nombres físicos de tablas (ej., `estudiante` -> `sweb_estudiantes`). Esto es crucial para entender la estructura de la base de datos.
4.  **Dependencias:** Instale las dependencias de PHP usando Composer:

    ```bash
    composer install
    ```
    **Nota:** El script `frontend/bin/publish.php` se ejecuta automáticamente después de `composer install` para copiar los assets frontend necesarios.

## Configuración del Frontend

No se requiere ningún paso de construcción del frontend. Los assets del frontend se gestionan directamente en el directorio `frontend/public` a través del script `publish.php` ejecutado por Composer.

# Convenciones de Desarrollo

## Estilo de Código

*   El proyecto utiliza PHP Mess Detector (`phpmd.xml`) y Code Climate (`codeclimate.yml`) para hacer cumplir la calidad del código.
*   Los nombres de los archivos están en español, mientras que parte del código está en inglés.

## Pruebas

*   El proyecto tiene un directorio de `tests`, pero no hay una documentación clara sobre cómo ejecutar las pruebas.
*   **PENDIENTE:** Documentar la estrategia de pruebas y cómo ejecutarlas.