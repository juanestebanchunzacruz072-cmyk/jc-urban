<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with initial JC URBAN data.
     */
    public function run(): void
    {
        // Roles
        DB::table('roles')->insert([
            ['id' => 1, 'nombre' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Cliente', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Estados de pedido
        DB::table('estado_pedido')->insert([
            ['id' => 1, 'nombre' => 'Pendiente', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Pagado', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Empacado', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'Enviado', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'Recibido', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'nombre' => 'Entregado', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Categorías principales
        DB::table('categorias')->insert([
            ['id' => 1, 'nombre' => 'Relojes', 'descripcion' => 'Relojes de lujo y alta relojería', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Perfumes', 'descripcion' => 'Fragancias exclusivas y de diseñador', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Accesorios', 'descripcion' => 'Gorras, billeteras, carrieles y correas de lujo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Subcategorías
        DB::table('subcategorias')->insert([
            // Relojes
            ['nombre' => 'Alta gama', 'id_categoria' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Originales', 'id_categoria' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Réplicas', 'id_categoria' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '1.1', 'id_categoria' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            // Perfumes
            ['nombre' => 'Originales', 'id_categoria' => 2, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Alta gama', 'id_categoria' => 2, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            // Accesorios
            ['nombre' => 'Gorras', 'id_categoria' => 3, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Billeteras', 'id_categoria' => 3, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Carrieles', 'id_categoria' => 3, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Correas', 'id_categoria' => 3, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Marcas de lujo (Exacto al Screenshot 3)
        DB::table('marcas')->insert([
            ['id' => 44, 'nombre' => 'Tommy hilfiger', 'descripcion' => 'Tommy Hilfiger es una marca de moda global de origen estadounidense y el nombre ...', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'nombre' => 'Gucci', 'descripcion' => 'Gucci es una famosa casa de moda de lujo italiana fundada en Florencia en 1921 p...', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'nombre' => 'Audemars Piguet', 'descripcion' => 'Marca de relojes de alta gama y diseño técnico', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'nombre' => 'Patek Philippe', 'descripcion' => 'Marca de relojes de lujo y prestigio mundial', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'nombre' => 'New Era', 'descripcion' => 'Marca líder en gorras urbanas y accesorios deportivos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'nombre' => 'Jordan', 'descripcion' => 'Marca deportiva y urbana de ropa, gorras y calzado', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'nombre' => 'Hugo Boss', 'descripcion' => 'Marca de moda, accesorios y perfumes de diseñador', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Rolex', 'descripcion' => 'Marca de relojes de lujo y prestigio mundial', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'Lattafa', 'descripcion' => 'Perfumería oriental exclusiva de alta fijación', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Usuario Administrador (Exacto al Screenshot)
        User::create([
            'name' => 'Administrador',
            'apellido' => '',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('Admin@2025'),
            'id_rol' => 1,
            'telefono' => '3000000000',
            'ciudad' => 'Medellín',
            'activo' => true,
        ]);

        User::create([
            'name' => 'Admin',
            'apellido' => 'JC URBAN',
            'email' => 'admin@jcurban.com',
            'password' => Hash::make('Admin@2025'),
            'id_rol' => 1,
            'telefono' => '3000000000',
            'ciudad' => 'Medellín',
            'activo' => true,
        ]);

        // 7 Clientes del Screenshot 4
        $ruben = User::create([
            'name' => 'Rubén',
            'apellido' => 'Dario Cruz',
            'cedula' => '65655599',
            'email' => 'ruben@gmail.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '65655599',
            'direccion' => 'CALLE 26 8D 23 CAMBULOS',
            'barrio' => 'CAMBULOS',
            'ciudad' => 'nrica',
            'created_at' => '2026-10-23 09:57:00',
            'activo' => true,
        ]);

        $ronald = User::create([
            'name' => 'ronald',
            'apellido' => 'rodriguez',
            'cedula' => '3204988989',
            'email' => 'ronald@gmail.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '3204988989',
            'direccion' => 'Cl 12 Sur # 24-42',
            'barrio' => 'Sur',
            'ciudad' => 'Neiva',
            'created_at' => '2026-09-23 11:50:00',
            'activo' => true,
        ]);

        User::create([
            'name' => 'Juan',
            'apellido' => 'cruz',
            'cedula' => '3204331237',
            'email' => 'juancruz@gmail.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '3204331237',
            'direccion' => 'Cl 20 Sur # 24-42',
            'barrio' => 'Sur',
            'ciudad' => 'Neiva',
            'created_at' => '2026-08-21 15:30:00',
            'activo' => true,
        ]);

        User::create([
            'name' => 'Isabella',
            'apellido' => 'Perdomo',
            'cedula' => '55555555',
            'email' => 'isabella@gmail.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '55555555',
            'direccion' => '895627',
            'barrio' => 'Centro',
            'ciudad' => 'Neiva',
            'created_at' => '2026-08-21 16:45:00',
            'activo' => true,
        ]);

        User::create([
            'name' => 'luz adriana',
            'apellido' => 'cruz garcia',
            'cedula' => '3138088095',
            'email' => 'luz@gmail.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '3138088095',
            'direccion' => 'Cl 20 Sur # 24-42',
            'barrio' => 'Sur',
            'ciudad' => 'Neiva',
            'created_at' => '2026-08-19 14:20:00',
            'activo' => true,
        ]);

        User::create([
            'name' => 'shary valentina',
            'apellido' => 'veru cruz',
            'cedula' => '3133920299',
            'email' => 'shary@gmail.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '3133920299',
            'direccion' => 'Cl 20 Sur # 24-42',
            'barrio' => 'Sur',
            'ciudad' => 'Neiva',
            'created_at' => '2026-08-19 15:10:00',
            'activo' => true,
        ]);

        User::create([
            'name' => 'wilson',
            'apellido' => 'romero',
            'cedula' => '3219648039',
            'email' => 'wilsonromero@gmail.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '3219648039',
            'direccion' => 'Cl 18 bis sur #23a -17 timanco',
            'barrio' => 'timanco',
            'ciudad' => 'Neiva',
            'created_at' => '2026-08-17 18:00:00',
            'activo' => true,
        ]);

        // ─── 5 PRODUCTOS EXACTOS DEL SCREENSHOT 1 Y 2 ($6.755.000 TOTAL) ───
        $productosData = [
            [
                'id' => 22,
                'nombre' => 'Audemars Piguet',
                'sku' => '413214132412',
                'genero' => 'Hombre',
                'descripcion' => 'Cronógrafo de alta gama y diseño técnico en oro rosa con bisel octogonal y brazalete integrado.',
                'precio' => 140000,
                'stock' => 4,
                'id_marca' => 22, // Audemars Piguet
                'id_categoria' => 1, // Relojes
                'id_subcategoria' => 3, // Réplicas
                'imagen' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'id' => 18,
                'nombre' => 'Carriel Gucci con Abeja Metálica',
                'sku' => 'CAR-GUC-002',
                'genero' => 'Hombre',
                'descripcion' => 'Bolso cruzado carriel Gucci confeccionado en lona GG Supreme con detalle de abeja metálica dorada envejecida y correa web ajustable en tribanda verde y roja.',
                'precio' => 120000,
                'stock' => 10,
                'id_marca' => 40, // Gucci
                'id_categoria' => 3, // Accesorios
                'id_subcategoria' => 9, // Carrieles
                'imagen' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'id' => 4,
                'nombre' => 'Yara Elixir',
                'sku' => '6290362346531',
                'genero' => 'Mujer',
                'descripcion' => 'Fragancia gourmand celestial con notas de fresa, bayas silvestres, vainilla y almizcle.',
                'precio' => 225000,
                'stock' => 7,
                'id_marca' => 5, // Lattafa
                'id_categoria' => 2, // Perfumes
                'id_subcategoria' => 6, // 1.1 / Alta gama
                'imagen' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'id' => 3,
                'nombre' => 'Khamrah',
                'sku' => '6291108737194',
                'genero' => 'Unisex (Ambos)',
                'descripcion' => 'Fragancia gourmand de lujo con canela, dátiles, praliné y vainilla en frasco de cristal tallado.',
                'precio' => 210000,
                'stock' => 6,
                'id_marca' => 5, // Lattafa
                'id_categoria' => 2, // Perfumes
                'id_subcategoria' => 6, // 1.1
                'imagen' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'id' => 1,
                'nombre' => 'Rolex Day-Date 40',
                'sku' => 'REF-18238',
                'genero' => 'Hombre',
                'descripcion' => 'El Rolex Day-Date 40 es el reloj de prestigio por excelencia con brazalete President.',
                'precio' => 1080000,
                'stock' => 2,
                'id_marca' => 3, // Rolex
                'id_categoria' => 1, // Relojes
                'id_subcategoria' => 1, // Alta gama
                'imagen' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=700&q=80',
            ],
        ];

        foreach ($productosData as $pData) {
            $imagen = $pData['imagen'];
            unset($pData['imagen']);

            DB::table('productos')->insert([
                'id' => $pData['id'],
                'nombre' => $pData['nombre'],
                'sku' => $pData['sku'],
                'genero' => $pData['genero'],
                'descripcion' => $pData['descripcion'],
                'precio' => $pData['precio'],
                'stock' => $pData['stock'],
                'id_marca' => $pData['id_marca'],
                'id_categoria' => $pData['id_categoria'],
                'id_subcategoria' => $pData['id_subcategoria'],
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('imagen_producto')->insert([
                'id_producto' => $pData['id'],
                'url_imagen' => $imagen,
                'principal' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── 2 PEDIDOS DE MUESTRA (EXACTOS AL SCREENSHOT 5) ─────────────
        $pedidosSeed = [
            ['id' => 2, 'id_usuario' => $ruben->id, 'total' => 450000, 'id_estado' => 2, 'created_at' => '2026-10-23 09:57:00'],
            ['id' => 1, 'id_usuario' => $ronald->id, 'total' => 420000, 'id_estado' => 6, 'created_at' => '2026-09-23 11:50:00'],
        ];

        foreach ($pedidosSeed as $ped) {
            DB::table('pedidos')->insert([
                'id' => $ped['id'],
                'id_usuario' => $ped['id_usuario'],
                'total' => $ped['total'],
                'id_estado' => $ped['id_estado'],
                'created_at' => $ped['created_at'],
                'updated_at' => $ped['created_at'],
            ]);
        }
    }
}
