# SIPeIP - Modulo de Planificacion

Proyecto academico construido con Laravel para el caso de estudio SIPeIP.

El desarrollo se realizara paso a paso, tomando como referencia la estructura
del proyecto `pp2026-master`: controladores REST por recurso, modelos Eloquent,
vistas Blade organizadas por modulo, parciales reutilizables, rutas agrupadas
por middleware y pruebas por funcionalidad.

## Estructura base esperada

```text
app/
  Http/
    Controllers/
    Middleware/
    Requests/
  Models/
  Policies/
database/
  factories/
  migrations/
  seeders/
docs/
resources/
  views/
    layouts/
    partials/
    <modulo>/
routes/
tests/
  Feature/
  Unit/
```

## Modelo de codificacion

- Clases y tablas en ingles siguiendo convenciones Laravel.
- Textos de interfaz en espanol.
- Un controlador por recurso principal.
- Vistas por carpeta de modulo: `index`, `create`, `edit`, `show`.
- Validaciones en controladores al inicio, luego en Form Requests cuando crezca.
- Relaciones Eloquent explicitas en los modelos.
- Middleware y policies para control de acceso.
- Tests de feature para rutas, permisos y flujos CRUD.
- Commits pequenos, probados y subidos al workflow por bloque.

## Documentacion

La carpeta `docs/` describe la estructura y las reglas de trabajo antes de
implementar nuevas funcionalidades.

## Workflow

El proyecto ya cuenta con GitHub Actions. Cada avance debe dejar el proyecto en
estado verificable para que el workflow pueda instalar dependencias, compilar
assets y ejecutar pruebas.
