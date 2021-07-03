<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /*
       $useradmin= User::create([
            'name'  => 'administrador',
            'email'     => 'admin@sisga.com',
            'password'  => bcrypt('#123456#'),
        ]);
    
        #Rol admin
        $rolAdmin = Role::create([
            'name'=>'Admin',
            'slug'=>'admin',
            'description'=>'Administrador',
            'full-access'=>'yes',
        ]);

        #User-Rol
        $useradmin->roles()->sync([$rolAdmin->id]);

*/
/*        
        #Creamos los Permisos para el Modulo de Rol 

        $permission = Permission::create([
            'name'=>'Lista rol',
            'slug'=>'roles.index',
            'description'=>'Permite ver la lista de roles',
        ]);

        $permission = Permission::create([
            'name'=>'Crear rol',
            'slug'=>'roles.create',
            'description'=>'Usuario podrá ver el formulario para crear una o más roles',
        ]);

        $permission = Permission::create([
            'name'=>'Guardar rol',
            'slug'=>'roles.store',
            'description'=>'Usuario podrá guardar una o más roles',
        ]);

        $permission = Permission::create([
            'name'=>'Editar rol',
            'slug'=>'roles.edit',
            'description'=>'Usuario podrá ver el formulario para editar un rol',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar rol',
            'slug'=>'roles.update',
            'description'=>'Usuario podrá actualizar los registros de un Rol',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar rol',
            'slug'=>'roles.destroy',
            'description'=>'Usuario podrá borrar los registros de un rol',
        ]); 

        #Creamos los Permisos para el Modulo de Usuario 

        $permission = Permission::create([
            'name'=>'Lista usuario',
            'slug'=>'usuario.index',
            'description'=>'Permite ver la lista de usuario',
        ]);

        $permission = Permission::create([
            'name'=>'Crear usuario',
            'slug'=>'usuario.create',
            'description'=>'Perfil podrá ver el formulario para crear una o más usuario',
        ]);

        $permission = Permission::create([
            'name'=>'Guardar usuario',
            'slug'=>'usuario.store',
            'description'=>'Perfil podrá guardar una o más usuario',
        ]);

        $permission = Permission::create([
            'name'=>'Editar usuario',
            'slug'=>'usuario.edit',
            'description'=>'Perfil podrá ver el formulario para editar un usuario',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar usuario',
            'slug'=>'usuario.update',
            'description'=>'Perfil podrá actualizar los registros de un usuario',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar usuario',
            'slug'=>'usuario.destroy',
            'description'=>'Perfil podrá borrar los registros de un usuario',
        ]); 
*/

/*
        $permission = Permission::create([
            'name'=>'Lista finca',
            'slug'=>'home',
            'description'=>'Permite ver la lista de finca',
        ]);

        $permission = Permission::create([
            'name'=>'Crear finca',
            'slug'=>'fincas.crear',
            'description'=>'Usuario podrá ver el formulario para crear una o más finca',
        ]);

        $permission = Permission::create([
            'name'=>'Editar finca',
            'slug'=>'fincas.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más finca',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar finca',
            'slug'=>'fincas.update',
            'description'=>'Usuario podrá actualizar los registros de una finca',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar finca',
            'slug'=>'fincas.eliminar',
            'description'=>'Usuario podrá borrar los registros de una finca',
        ]);
        # /fin Permisos Finca.
   
        $permission = Permission::create([
            'name'=>'Lista especie',
            'slug'=>'especie',
            'description'=>'Permite ver la lista de especie',
        ]);

        $permission = Permission::create([
            'name'=>'Crear especie',
            'slug'=>'especie.crear',
            'description'=>'Usuario podrá ver el formulario para crear una o más especie',
        ]);

        $permission = Permission::create([
            'name'=>'Editar especie',
            'slug'=>'especie.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más especie',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar especie',
            'slug'=>'especie.update',
            'description'=>'Usuario podrá actualizar los registros de una especie',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar especie',
            'slug'=>'especie.eliminar',
            'description'=>'Usuario podrá borrar los registros de una especie',
        ]);     

        $permission = Permission::create([
            'name'=>'Lista raza',
            'slug'=>'raza',
            'description'=>'Permite ver la lista de raza',
        ]);

        $permission = Permission::create([
            'name'=>'Crear raza',
            'slug'=>'raza.crear',
            'description'=>'Usuario podrá ver el formulario para crear una o más raza',
        ]);

        $permission = Permission::create([
            'name'=>'Editar raza',
            'slug'=>'raza.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más raza',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar raza',
            'slug'=>'raza.update',
            'description'=>'Usuario podrá actualizar los registros de una raza',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar raza',
            'slug'=>'raza.eliminar',
            'description'=>'Usuario podrá borrar los registros de una raza',
        ]);
   
         $permission = Permission::create([
            'name'=>'Lista tipologia',
            'slug'=>'tipologia',
            'description'=>'Permite ver la lista de tipologia',
        ]);

        $permission = Permission::create([
            'name'=>'Crear tipologia',
            'slug'=>'tipologia.crear',
            'description'=>'Usuario podrá ver el formulario para crear una o más tipologia',
        ]);

        $permission = Permission::create([
            'name'=>'Editar tipologia',
            'slug'=>'tipologia.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más tipologia',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar tipologia',
            'slug'=>'tipologia.update',
            'description'=>'Usuario podrá actualizar los registros de una tipologia',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar tipologia',
            'slug'=>'tipologia.eliminar',
            'description'=>'Usuario podrá borrar los registros de una tipologia',
        ]);
    

        $permission = Permission::create([
            'name'=>'Lista Condición Corporal',
            'slug'=>'condicion_corporal',
            'description'=>'Permite ver la lista de condicion corporal',
        ]);

        $permission = Permission::create([
            'name'=>'Crear condicion_corporal',
            'slug'=>'condicion_corporal.crear',
            'description'=>'Usuario podrá ver el formulario para crear una o más condicion corporal',
        ]);

        $permission = Permission::create([
            'name'=>'Editar condicion_corporal',
            'slug'=>'condicion_corporal.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más condicion corporal',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar condicion_corporal',
            'slug'=>'condicion_corporal.update',
            'description'=>'Usuario podrá actualizar los registros de una condicion corporal',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar condicion_corporal',
            'slug'=>'condicion_corporal.eliminar',
            'description'=>'Usuario podrá borrar los registros de una condicion corporal',
        ]); 


        $permission = Permission::create([
            'name'=>'Lista Palpaciones',
            'slug'=>'diagnostico_palpaciones',
            'description'=>'Permite ver la lista de Palpaciones',
        ]);

        $permission = Permission::create([
            'name'=>'Crear Palpaciones',
            'slug'=>'diagnostico_palpaciones.crear',
            'description'=>'Usuario podrá ver el formulario para crear una o más Palpaciones',
        ]);

        $permission = Permission::create([
            'name'=>'Editar Palpaciones',
            'slug'=>'diagnostico_palpaciones.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más Palpaciones',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar Palpaciones',
            'slug'=>'diagnostico_palpaciones.update',
            'description'=>'Usuario podrá actualizar los registros de una Palpaciones',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar Palpaciones',
            'slug'=>'diagnostico_palpaciones.eliminar',
            'description'=>'Usuario podrá borrar los registros de una Palpaciones',
        ]);   

        $permission = Permission::create([
            'name'=>'Lista colores',
            'slug'=>'colores',
            'description'=>'Permite ver la lista de colores',
        ]);

        $permission = Permission::create([
            'name'=>'Crear colores',
            'slug'=>'colores.crear',
            'description'=>'Usuario podrá ver el formulario para crear una o más colores',
        ]);

        $permission = Permission::create([
            'name'=>'Editar colores',
            'slug'=>'colores.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más colores',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar colores',
            'slug'=>'colores.update',
            'description'=>'Usuario podrá actualizar los registros de una colores',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar colores',
            'slug'=>'colores.eliminar',
            'description'=>'Usuario podrá borrar los registros de una colores',
        ]);


        $permission = Permission::create([
            'name'=>'Lista parametros',
            'slug'=>'parametros',
            'description'=>'Permite ver la lista de parametros',
        ]);

        $permission = Permission::create([
            'name'=>'Crear parametros ganadería',
            'slug'=>'parametros_ganaderia.crear',
            'description'=>'Usuario podrá ver el formulario para crear uno o más parámetros de ganadería',
        ]);

        $permission = Permission::create([
            'name'=>'Crear parametros reproduccion',
            'slug'=>'parametros_reproduccion.crear',
            'description'=>'Usuario podrá ver el formulario para crear uno o más parámetros de reproducción animal',
        ]);

        $permission = Permission::create([
            'name'=>'Crear parametros produccion de Leche',
            'slug'=>'parametros_produccion_leche.crear',
            'description'=>'Usuario podrá ver el formulario para crear uno o más parámetros de producción de leche',
        ]);

        $permission = Permission::create([
            'name'=>'Editar parametros ganadería',
            'slug'=>'parametros_ganaderia.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más parámetros de ganadería',
        ]);

        $permission = Permission::create([
            'name'=>'Editar parametros reproduccion',
            'slug'=>'parametros_reproduccion.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más parámetros de reproducción animal',
        ]);

        $permission = Permission::create([
            'name'=>'Editar parametros produccion de Leche',
            'slug'=>'parametros_produccion_leche.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más parámetros de producción de leche',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar parametros ganadería',
            'slug'=>'parametros_ganaderia.update',
            'description'=>'Usuario podrá actualizar una o más parámetros de ganadería',
        ]);

        $permission = Permission::create([
            'name'=>'Actualiar parametros reproduccion',
            'slug'=>'parametros_reproduccion.update',
            'description'=>'Usuario podrá actualizar una o más parámetros de reproducción animal',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar parametros produccion de Leche',
            'slug'=>'parametros_produccion_leche.update',
            'description'=>'Usuario podrá actualizar una o más parámetros de producción de leche',
        ]);
    
        $permission = Permission::create([
            'name'=>'Lista de Motivos Entrada/Salida',
            'slug'=>'motivo_entrada_salida',
            'description'=>'Permite ver la lista de E/S',
        ]);

        $permission = Permission::create([
            'name'=>'Crear de Motivos Entrada/Salida',
            'slug'=>'motivo_entrada_salida.crear',
            'description'=>'Usuario podrá ver el formulario para crear una o más de Motivos Entrada/Salida',
        ]);

        $permission = Permission::create([
            'name'=>'Editar de Motivos Entrada/Salida',
            'slug'=>'motivo_entrada_salida.editar',
            'description'=>'Usuario podrá ver el formulario para editar una o más de Motivos Entrada/Salida',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar de Motivos Entrada/Salida',
            'slug'=>'motivo_entrada_salida.update',
            'description'=>'Usuario podrá actualizar los registros de una de Motivos Entrada/Salida',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar de Motivos Entrada/Salida',
            'slug'=>'motivo_entrada_salida.eliminar',
            'description'=>'Usuario podrá borrar los registros de una de Motivos Entrada/Salida',
        ]);

        $permission = Permission::create([
            'name'=>'Lista patologia',
            'slug'=>'patologia',
            'description'=>'Permite ver la lista de patologia',
        ]);

        $permission = Permission::create([
            'name'=>'Crear patologia',
            'slug'=>'patologia.crear',
            'description'=>'Usuario podrá ver el formulario para crear una patologia',
        ]);

        $permission = Permission::create([
            'name'=>'Editar patologia',
            'slug'=>'patologia.editar',
            'description'=>'Usuario podrá ver el formulario para editar una patologia',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar patologia',
            'slug'=>'patologia.update',
            'description'=>'Usuario podrá actualizar los registros de una  patologia',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar patologia',
            'slug'=>'patologia.eliminar',
            'description'=>'Usuario podrá borrar los registros de una patologia',
        ]);        


        $permission = Permission::create([
            'name'=>'Lista de tipo de monta',
            'slug'=>'tipomonta',
            'description'=>'Permite ver la lista de tipomonta',
        ]);

        $permission = Permission::create([
            'name'=>'Crear tipo de monta',
            'slug'=>'tipomonta.crear',
            'description'=>'Usuario podrá ver el formulario para crear un tipo de monta',
        ]);

        $permission = Permission::create([
            'name'=>'Editar tipo de monta',
            'slug'=>'tipomonta.editar',
            'description'=>'Usuario podrá ver el formulario para editar un tipo de monta',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar tipo de monta',
            'slug'=>'tipomonta.update',
            'description'=>'Usuario podrá actualizar los registros de un tipo de monta',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar tipo de monta',
            'slug'=>'tipomonta.eliminar',
            'description'=>'Usuario podrá borrar los registros de un tipo de monta',
        ]);


        $permission = Permission::create([
            'name'=>'Lista de causa de muerte',
            'slug'=>'causamuerte',
            'description'=>'Permite ver la lista de causa de muerte',
        ]);

        $permission = Permission::create([
            'name'=>'Crear causa de muerte',
            'slug'=>'causamuerte.crear',
            'description'=>'Usuario podrá ver el formulario para crear una causa de muerte',
        ]);

        $permission = Permission::create([
            'name'=>'Editar causa de muerte',
            'slug'=>'causamuerte.editar',
            'description'=>'Usuario podrá ver el formulario para editar una causa de muerte',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar causa de muerte',
            'slug'=>'causamuerte.update',
            'description'=>'Usuario podrá actualizar los registros de una causa de muerte',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar causa de muerte',
            'slug'=>'causamuerte.eliminar',
            'description'=>'Usuario podrá borrar los registros de una causa de muerte',
        ]);
    
        $permission = Permission::create([
            'name'=>'Lista de destino de salida',
            'slug'=>'destinosalida',
            'description'=>'Permite ver la lista de destino de salida',
        ]);

        $permission = Permission::create([
            'name'=>'Crear destino de salida',
            'slug'=>'destinosalida.crear',
            'description'=>'Usuario podrá ver el formulario para crear un destino de salida',
        ]);

        $permission = Permission::create([
            'name'=>'Editar destino de salida',
            'slug'=>'destinosalida.editar',
            'description'=>'Usuario podrá ver el formulario para editar un destino de salida',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar destino de salida',
            'slug'=>'destinosalida.update',
            'description'=>'Usuario podrá actualizar los registros de un destino de salida',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar destino de salida',
            'slug'=>'destinosalida.eliminar',
            'description'=>'Usuario podrá borrar los registros de un destino de salida',
        ]);


        $permission = Permission::create([
            'name'=>'Lista de procedencia',
            'slug'=>'procedencia',
            'description'=>'Permite ver la lista de procedencia',
        ]);

        $permission = Permission::create([
            'name'=>'Crear procedencia',
            'slug'=>'procedencia.crear',
            'description'=>'Usuario podrá ver el formulario para crear una procedencia',
        ]);

        $permission = Permission::create([
            'name'=>'Editar procedencia',
            'slug'=>'procedencia.editar',
            'description'=>'Usuario podrá ver el formulario para editar una procedencia',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar procedencia',
            'slug'=>'procedencia.update',
            'description'=>'Usuario podrá actualizar los registros de una procedencia',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar procedencia',
            'slug'=>'procedencia.eliminar',
            'description'=>'Usuario podrá borrar los registros de una procedencia',
        ]);


        $permission = Permission::create([
            'name'=>'Lista de sala de ordeño',
            'slug'=>'salaordeno',
            'description'=>'Permite ver la lista de sala de ordeño',
        ]);

        $permission = Permission::create([
            'name'=>'Crear sala de ordeño',
            'slug'=>'salaordeno.crear',
            'description'=>'Usuario podrá ver el formulario para crear una sala de ordeño',
        ]);

        $permission = Permission::create([
            'name'=>'Editar sala de ordeño',
            'slug'=>'salaordeno.editar',
            'description'=>'Usuario podrá ver el formulario para editar una sala de ordeño',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar sala de ordeño',
            'slug'=>'salaordeno.update',
            'description'=>'Usuario podrá actualizar los registros de una sala de ordeño',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar sala de ordeño',
            'slug'=>'salaordeno.eliminar',
            'description'=>'Usuario podrá borrar los registros de una sala de ordeño',
        ]);


        $permission = Permission::create([
            'name'=>'Lista de tanque de enfriamiento',
            'slug'=>'tanque',
            'description'=>'Permite ver la lista de tanque de enfriamiento',
        ]);

        $permission = Permission::create([
            'name'=>'Crear tanque de enfriamiento',
            'slug'=>'tanque.crear',
            'description'=>'Usuario podrá ver el formulario para crear un tanque de enfriamiento',
        ]);

        $permission = Permission::create([
            'name'=>'Editar tanque de enfriamiento',
            'slug'=>'tanque.editar',
            'description'=>'Usuario podrá ver el formulario para editar un tanque de enfriamiento',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar tanque de enfriamiento',
            'slug'=>'tanque.update',
            'description'=>'Usuario podrá actualizar los registros de un tanque de enfriamiento',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar tanque de enfriamiento',
            'slug'=>'tanque.eliminar',
            'description'=>'Usuario podrá borrar los registros de un tanque de enfriamiento',
        ]);


        $permission = Permission::create([
            'name'=>'Muestra Ficha de ganado',
            'slug'=>'ficha',
            'description'=>'Permite ver la ficha de ganado',
        ]);

        $permission = Permission::create([
            'name'=>'Crear ficha de ganado',
            'slug'=>'ficha.crear',
            'description'=>'Usuario podrá ver el formulario para crear una ficha de ganado',
        ]);

        $permission = Permission::create([
            'name'=>'Editar ficha de ganado',
            'slug'=>'ficha.editar',
            'description'=>'Usuario podrá ver el formulario para editar una ficha de ganado',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar ficha de ganado',
            'slug'=>'ficha.update',
            'description'=>'Usuario podrá actualizar los registros de una fihca de ganado',
        ]);


        $permission = Permission::create([
            'name'=>'Lista Lote',
            'slug'=>'lote',
            'description'=>'Permite ver la lista de lote',
        ]);

        $permission = Permission::create([
            'name'=>'Crear lote',
            'slug'=>'lote.crear',
            'description'=>'Usuario podrá ver el formulario para crear un lote',
        ]);

        $permission = Permission::create([
            'name'=>'Editar lote',
            'slug'=>'lote.editar',
            'description'=>'Usuario podrá ver el formulario para editar un lote',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar lote',
            'slug'=>'lote.update',
            'description'=>'Usuario podrá actualizar los registros de un lote',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar lote',
            'slug'=>'lote.eliminar',
            'description'=>'Usuario podrá borrar los registros de un lote',
        ]);


        $permission = Permission::create([
            'name'=>'Cambio de Tipologia',
            'slug'=>'cambio_tipologia',
            'description'=>'Permite ver la lista de lote',
        ]);

        $permission = Permission::create([
            'name'=>'Crear cambio de tipología',
            'slug'=>'cambio_tipologia.cambiar',
            'description'=>'Usuario podrá ver el formulario para crear un cambio de tippología',
        ]);


        $permission = Permission::create([
            'name'=>'Transferencia',
            'slug'=>'transferencia',
            'description'=>'Permite ver las transferencia',
        ]);

        $permission = Permission::create([
            'name'=>'Crear Transferencia',
            'slug'=>'serie.transferir',
            'description'=>'Usuario podrá ver el formulario para crear una transferencia',
        ]);
    
        $permission = Permission::create([
            'name'=>'salida',
            'slug'=>'salida',
            'description'=>'Permite ver las salida de animales',
        ]);

        $permission = Permission::create([
            'name'=>'Crear salida',
            'slug'=>'serie.salida',
            'description'=>'Usuario podrá ver el formulario para crear una salida de uno o más animales',
        ]);

        $permission = Permission::create([
            'name'=>'Peso ajustado',
            'slug'=>'peso_ajustado',
            'description'=>'Permite ver las series para calcular su peso ajustado.',
        ]);
    
        $permission = Permission::create([
            'name'=>'Lista de Pajuela',
            'slug'=>'pajuela',
            'description'=>'Permite ver la lista de pajuela',
        ]);

        $permission = Permission::create([
            'name'=>'Crear pajuela',
            'slug'=>'pajuela.crear',
            'description'=>'Usuario podrá ver el formulario para crear una pajuela',
        ]);

        $permission = Permission::create([
            'name'=>'Editar pajuela',
            'slug'=>'pajuela.editar',
            'description'=>'Usuario podrá ver el formulario para editar una pajuela',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar pajuela',
            'slug'=>'pajuela.update',
            'description'=>'Usuario podrá actualizar los registros de una pajuela',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar pajuela',
            'slug'=>'pajuela.eliminar',
            'description'=>'Usuario podrá borrar los registros de una pajuela',
        ]);
    
        $permission = Permission::create([
            'name'=>'Crear temporada',
            'slug'=>'temporada.crear',
            'description'=>'Usuario podrá ver el formulario para crear una temporada',
        ]);

        $permission = Permission::create([
            'name'=>'Editar temporada',
            'slug'=>'temporada.editar',
            'description'=>'Usuario podrá ver el formulario para editar una temporada',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar temporada',
            'slug'=>'temporada.update',
            'description'=>'Usuario podrá actualizar los registros de una temporada',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar temporada',
            'slug'=>'temporada.eliminar',
            'description'=>'Usuario podrá borrar los registros de una temporada',
        ]);
    
        $permission = Permission::create([
            'name'=>'Cerrar temporada',
            'slug'=>'temporada.cerrar',
            'description'=>'Usuario podrá cerrar una temporada',
        ]);  
    
        $permission = Permission::create([
            'name'=>'Ciclo',
            'slug'=>'ciclo',
            'description'=>'Usuario podrá acceder al formulario para crear un ciclo',
        ]);

        $permission = Permission::create([
            'name'=>'Crear ciclo',
            'slug'=>'ciclo.crear',
            'description'=>'Usuario podrá  crear un ciclo',
        ]);

        $permission = Permission::create([
            'name'=>'Editar ciclo',
            'slug'=>'ciclo.editar',
            'description'=>'Usuario podrá ver el formulario para editar un ciclo',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar ciclo',
            'slug'=>'ciclo.update',
            'description'=>'Usuario podrá actualizar los registros de un ciclo',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar ciclo',
            'slug'=>'ciclo.eliminar',
            'description'=>'Usuario podrá borrar los registros de un ciclo',
        ]);
          
        $permission = Permission::create([
            'name'=>'Series a un lote de monta',
            'slug'=>'serieslotemonta',
            'description'=>'Usuario podrá ver las series que pueden ser asignadas a un lote de monta',
        ]);

        $permission = Permission::create([
            'name'=>'Asignar series a un lote de monta',
            'slug'=>'asignarserieslotemonta',
            'description'=>'Usuario podrá asignar una o más series a un lote de monta',
        ]);

        $permission = Permission::create([
            'name'=>'Lote de monta',
            'slug'=>'lotemonta',
            'description'=>'Usuario podrá acceder al formulario para crear un lote de monta',
        ]);

        $permission = Permission::create([
            'name'=>'Crear lote de monta',
            'slug'=>'lotemonta.crear',
            'description'=>'Usuario podrá  crear un lote de monta',
        ]);

        $permission = Permission::create([
            'name'=>'Editar lote de monta',
            'slug'=>'lotemonta.editar',
            'description'=>'Usuario podrá ver el formulario para editar un lote de monta',
        ]);

        $permission = Permission::create([
            'name'=>'Actualizar Lote de monta',
            'slug'=>'lotemonta.update',
            'description'=>'Usuario podrá actualizar los registros de un lote de monta',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar lote de monta',
            'slug'=>'lotemonta.eliminar',
            'description'=>'Usuario podrá borrar los registros de un lote de monta',
        ]);
   
      $permission = Permission::create([
            'name'=>'inventario - Trabajo de Campo',
            'slug'=>'inventario',
            'description'=>'Usuario podrá acceder a la lista de trabajos de campos',
        ]);
  
        $permission = Permission::create([
            'name'=>'Crear trabajo de campo',
            'slug'=>'tc.crear',
            'description'=>'Usuario podrá  crear un trabajo de campo',
        ]);

        $permission = Permission::create([
            'name'=>'Detalles de trabajo de campo',
            'slug'=>'tc.detalle',
            'description'=>'Usuario podrá ver el detalle de un trabajo de campo',
        ]);

        $permission = Permission::create([
            'name'=>'Guardar trabajo de campo',
            'slug'=>'tc.guardar',
            'description'=>'Usuario podrá guardar los registros de un trabajo de campo',
        ]);

        $permission = Permission::create([
            'name'=>'Eliminar trabajo de campo',
            'slug'=>'tc.eliminar',
            'description'=>'Usuario podrá borrar los registros de un trabajo de campo',
        ]);  

        $permission = Permission::create([
            'name'=>'Comparar trabajo de campo',
            'slug'=>'vistacomparar',
            'description'=>'Usuario podrá comparar los registros de un trabajo de campo',
        ]);  
*/
    }
}
