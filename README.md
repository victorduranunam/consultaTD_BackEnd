# Backend de ConsultasTD

Este repositorio contiene el **backend** del proyecto **ConsultasTD**, desarrollado en **Laravel**.  
El backend se encarga de gestionar las consultas a la **API ConsultasTD**, conectándose a bases de datos **PostgreSQL** y proporcionando los datos necesarios al frontend o a otros servicios que consuman la API.

---

## 🔹 Objetivo

El objetivo de este proyecto es ofrecer un **servicio backend robusto y seguro** que permita realizar consultas relacionadas con los profesores, grupos y alumnos activos en el semestre actual, y entregar los datos de manera estructurada para su consumo por el frontend (desarrollado en PHP) u otras aplicaciones internas de administración de EDUCAFI.

---

## 🔹 Tecnologías utilizadas

- **Laravel (PHP)** → Framework para el desarrollo del backend.  
- **PostgreSQL** → Base de datos relacional donde se almacenan y consultan los datos.  
- **Composer** → Gestión de dependencias de PHP.  
- **REST API** → Para exponer los endpoints consumibles por el frontend.

---

## 🔹 Estructura del repositorio

- `app/` → Contiene los controladores, modelos y lógica de negocio de Laravel.  
- `routes/` → Definición de las rutas y endpoints de la API.  
- `database/` → Migraciones y seeds para la base de datos.  
- `config/` → Configuraciones del proyecto y de la conexión a PostgreSQL.  
- `README.md` → Este archivo con la documentación del backend.

---

## 🔹 Uso / Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/victorduranunam/consultaTD_backend.git
