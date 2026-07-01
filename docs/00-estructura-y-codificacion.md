# 00 - Estructura y Modelo de Codificacion

## Referencia

La estructura de trabajo tomara como referencia el proyecto `pp2026-master`.
Ese proyecto organiza cada funcionalidad como un recurso Laravel completo:

- Modelo Eloquent.
- Migracion.
- Factory cuando aplica.
- Controlador REST.
- Rutas `Route::resource`.
- Carpeta de vistas por modulo.
- Parciales Blade reutilizables.
- Pruebas Feature.

No se copiara el dominio de ecommerce. Solo se usara el mismo estilo de
organizacion para construir el dominio SIPeIP.

## Convenciones de nombres

### Codigo

Usaremos ingles en clases, modelos, tablas y relaciones:

```text
User
Role
Permission
PublicEntity
StrategicObjective
InstitutionalPlan
InvestmentProject
AuditLog
```

### Interfaz

Usaremos espanol para textos visibles:

```text
Usuarios
Roles
Entidades publicas
Objetivos estrategicos
Planes institucionales
Proyectos de inversion
Auditoria
Reportes
```

## Estructura por modulo

Cada modulo funcional deberia tener esta forma:

```text
app/Http/Controllers/PublicEntityController.php
app/Models/PublicEntity.php
database/migrations/xxxx_xx_xx_xxxxxx_create_public_entities_table.php
database/factories/PublicEntityFactory.php
resources/views/public-entities/index.blade.php
resources/views/public-entities/create.blade.php
resources/views/public-entities/edit.blade.php
resources/views/public-entities/show.blade.php
tests/Feature/PublicEntityTest.php
```

## Patron de rutas

Las rutas se agruparan por autenticacion y permisos:

```php
Route::middleware(['auth'])->group(function () {
    Route::resource('public-entities', PublicEntityController::class);
});
```

Cuando existan roles definidos:

```php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});
```

## Patron de controladores

Los controladores seguiran el estilo REST usado en `pp2026-master`:

```text
index()
create()
store()
show()
edit()
update()
destroy()
```

Reglas:

- `index`: listar registros.
- `create`: mostrar formulario.
- `store`: validar y crear.
- `show`: mostrar detalle.
- `edit`: mostrar formulario de edicion.
- `update`: validar y actualizar.
- `destroy`: eliminar o desactivar segun regla del negocio.

## Patron de modelos

Los modelos deben declarar:

- `$fillable` o atributos fillable.
- `casts()` para fechas, booleanos y decimales.
- Relaciones Eloquent.
- Metodos auxiliares simples cuando aporten claridad.

Ejemplo:

```php
class PublicEntity extends Model
{
    protected $fillable = ['code', 'name', 'status'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
```

## Patron de vistas

Se mantendra el patron Blade de `pp2026-master`:

- `layouts/app.blade.php` como layout principal.
- `partials/page-header.blade.php` para encabezados.
- `partials/form-field.blade.php` para campos comunes.
- `partials/form-actions.blade.php` para botones de formularios.
- `partials/action-buttons.blade.php` para ver, editar y eliminar.
- `partials/flash.blade.php` para mensajes.

Cada vista debe ser simple y consistente:

- Tablas en `index`.
- Tarjeta/formulario en `create` y `edit`.
- Detalle en `show`.
- Estados vacios claros.

## Pruebas

Cada modulo nuevo debe tener al menos pruebas Feature para:

- Acceso autenticado.
- Restricciones por rol cuando aplique.
- Crear registro valido.
- Validar datos requeridos.
- Editar registro.
- Eliminar o desactivar registro.

## Orden de construccion recomendado

1. Documentacion y estructura.
2. Roles base y middleware.
3. Usuarios institucionales.
4. Entidades publicas.
5. Objetivos estrategicos.
6. PND y ODS.
7. Planes institucionales.
8. Proyectos de inversion.
9. Auditoria.
10. Reportes.

## Regla para el workflow

Cada cambio debe quedar pequeno y comprobable. Primero se prueba localmente y
luego se sube al repositorio para ejecutar GitHub Actions.
