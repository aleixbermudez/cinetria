# ![Cinetria Logo](public/images/cinetria.png)

# 🎬 Cinetria

**Cinetria** es una aplicación web desarrollada con Laravel, diseñada para que los usuarios puedan consultar información de películas y series, crear reseñas, interactuar con otros perfiles y participar en un foro con todas las reseñas compartidas.

---

## 🚀 Tecnologías utilizadas

- PHP 8.1
- Laravel 10
- MySQL
- Tailwind CSS
- Vite
- JavaScript puro
- SweetAlert2
- Swiper.js
- Laravel Breeze
- Laravel Spatie

---

## ⚙️ Cómo ejecutar el proyecto localmente

```bash
git clone https://github.com/aleixbermudez/cinetria-final.git
cd cinetria-final
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
npm run dev
```

---

## 📄 Documentación completa

### 🧠 Análisis

#### Nombre del proyecto
**Cinetria**

#### Breve descripción
Cinetria es un sitio web donde los usuarios pueden consultar información de películas y series, crear reseñas sobre ellas, explorar reseñas de otros usuarios, y participar en un foro.

#### Objetivos
- Proveer una plataforma para opinar sobre películas y series.
- Consultar reseñas de otros usuarios.
- Fomentar la interacción en una comunidad cinéfila.

#### Requisitos previos
- PHP 8.1
- Composer
- MySQL
- Node.js y NPM

Tecnologías y librerías utilizadas:
- Laravel 10
- Tailwind CSS
- Vite
- Swiper.js
- SweetAlert2
- JavaScript puro
- Laravel Breeze
- Laravel Spatie

#### Casos de uso
- Registro / Login
- Crear reseñas
- Consultar reseñas
- Marcar contenido como favorito
- Explorar reseñas de otros usuarios

---

### 🎨 Diseño

https://drive.google.com/file/d/1Vnuze_ShOpVN0Gc7lX_d6fKUL21SlAgh/view?usp=sharing

#### Diagrama Entidad-Relación

https://drive.google.com/file/d/1hHX3DMa0_dkWDEwt3CtqHIMSNaQ9SISa/view?usp=sharing

#### Estructura de la Base de Datos (SQL)

```sql
-- Tabla: users
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
);

-- Tabla: resenhas
CREATE TABLE `resenhas` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `id_usuario` VARCHAR(255) NOT NULL,
    `valoracion` VARCHAR(255) NOT NULL,
    `opinion_texto` VARCHAR(255),
    `id_contenido` VARCHAR(255) NOT NULL,
    `tipo_contenido` VARCHAR(255) NOT NULL
);

-- Tabla: favoritas
CREATE TABLE `table_favoritas` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `id_usuario` VARCHAR(255) NOT NULL,
    `titulo_contenido` VARCHAR(255) NOT NULL,
    `id_contenido` VARCHAR(255) NOT NULL,
    `tipo_contenido` VARCHAR(255) NOT NULL
);

```

#### Bocetos de diseño
*(Insertar capturas o enlaces a los diseños visuales de la interfaz de usuario)*

---

### ✅ Pruebas

#### Herramienta utilizada
- Postman

#### Tipos de pruebas realizadas
- ✅ Prueba de llamadas a la API (GET/POST)
- ✅ Inserción correcta en base de datos
- ✅ Comprobación de validaciones
- ✅ Comprobación de errores controlados
- ✅ Pruebas de autenticación


---

## 👤 Autores

Desarrollado por **Aleix Bermúdez y Milo Vocker**  
Proyecto del ciclo **Desarrollo de Aplicaciones Web (DAW)**

---

## 📬 Contacto

¿Tienes sugerencias o encontraste errores?  
Puedes abrir un **Issue** en este repositorio o contactar directamente.

milovocker.clase@gmail.com
aleixbermudez192@gmail.com

---
