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

        // Marcas de lujo
        DB::table('marcas')->insert([
            ['id' => 3, 'nombre' => 'Rolex', 'descripcion' => 'Marca de relojes de lujo y prestigio mundial', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'Richard Mille', 'descripcion' => 'Marca de relojes de alta gama y diseño técnico', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'nombre' => 'Patek Philippe', 'descripcion' => 'Marca de relojes de lujo y prestigio mundial', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'nombre' => 'Audemars Piguet', 'descripcion' => 'Marca de relojes de alta gama y diseño técnico', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'Lattafa', 'descripcion' => 'Perfumería oriental exclusiva de alta fijación', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'nombre' => 'Amiri', 'descripcion' => 'Accesorios urbanos de lujo y diseño contemporáneo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'nombre' => 'Gucci', 'descripcion' => 'Moda y marroquinería de alta costura italiana', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'nombre' => 'Coach', 'descripcion' => 'Artículos de piel refinada y accesorios neoyorquinos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'nombre' => 'Sin marca', 'descripcion' => 'Artículos genéricos o multimarca', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
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

        // Clientes del Screenshot 5
        $luz = User::create([
            'name' => 'luz adriana',
            'apellido' => 'cruz garcia',
            'cedula' => '52345678',
            'email' => 'luz.cruz@gmail.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '3104567890',
            'direccion' => 'Pendiente',
            'barrio' => 'El Poblado',
            'ciudad' => 'Medellín',
            'activo' => true,
        ]);

        $wilson = User::create([
            'name' => 'wilson',
            'apellido' => 'romero',
            'cedula' => '80123456',
            'email' => 'wilson.romero@gmail.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '3157891234',
            'direccion' => 'Pendiente',
            'barrio' => 'Chicó',
            'ciudad' => 'Bogotá',
            'activo' => true,
        ]);

        // ─── PRODUCTOS DE MUESTRA CON FOTOS DE ALTA RESOLUCIÓN ────────
        $productosData = [
            // Exactos del Screenshot 1 y 4
            [
                'nombre' => 'Rolex Day-Date 40',
                'sku' => 'REF-18238',
                'genero' => 'Hombre',
                'descripcion' => "El Rolex Day-Date 40 es el reloj de prestigio por excelencia. Fabricado exclusivamente en oro amarillo de 18 quilates con esfera verde olivo y bisel estriado icónico.\n\n• Movimiento automático calibre 3255 con 70 horas de reserva\n• Brazalete President con cierre oculto Crownclasp\n• Hermético hasta 100 metros con cristal de zafiro",
                'precio' => 1200000,
                'stock' => 5,
                'id_marca' => 3, // Rolex
                'id_categoria' => 1, // Relojes
                'id_subcategoria' => 1, // Alta gama
                'imagen' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'hugo boss',
                'sku' => 'HB-WAL-01',
                'genero' => 'Hombre',
                'descripcion' => 'Billetera clásica Hugo Boss elaborada en piel granulada suave con logotipo metálico sutil y compartimentos organizadores internos para tarjetas y billetes.',
                'precio' => 70000,
                'stock' => 10,
                'id_marca' => 9, // Sin marca / Hugo Boss
                'id_categoria' => 3, // Accesorios
                'id_subcategoria' => 8, // Billeteras
                'imagen' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Carriel Gucci con Abeja Metálica',
                'sku' => 'GC-CAR-02',
                'genero' => 'Hombre',
                'descripcion' => 'Bolso cruzado carriel Gucci confeccionado en lona GG Supreme con detalle de abeja metálica dorada envejecida y correa web ajustable en tribanda verde y roja.',
                'precio' => 120000,
                'stock' => 6,
                'id_marca' => 7, // Gucci
                'id_categoria' => 3, // Accesorios
                'id_subcategoria' => 9, // Carrieles
                'imagen' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Audemars Piguet Royal Oak Chronograph',
                'sku' => 'AP-ROC-26331',
                'genero' => 'Hombre',
                'descripcion' => "Cronógrafo legendario de 41 mm en oro rosa de 18 quilates con esfera marrón 'Grande Tapisserie', contadores dorados y agujas Royal Oak con revestimiento luminiscente.",
                'precio' => 1500000,
                'stock' => 4,
                'id_marca' => 22, // Audemars Piguet
                'id_categoria' => 1, // Relojes
                'id_subcategoria' => 1, // Alta gama
                'imagen' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Patek Philippe Aquanaut',
                'sku' => '5167A-001',
                'genero' => 'Hombre',
                'descripcion' => 'Es un reloj deportivo de lujo con caja de acero inoxidable de 40 mm, esfera negra repujada con números dorados luminiscentes, fecha a las 3 h y correa de caucho «Tropical» ultrarresistente. Cuenta con movimiento automático, fondo de zafiro y sumergibilidad de 120 metros',
                'precio' => 1800000,
                'stock' => 9,
                'id_marca' => 21, // Patek Philippe
                'id_categoria' => 1, // Relojes
                'id_subcategoria' => 1, // Alta gama
                'imagen' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Richard Mille RM 11-03 Flyback Chronograph',
                'sku' => 'RM-1103-F1',
                'genero' => 'Hombre',
                'descripcion' => 'El RM 11-03 es una obra maestra de la ingeniería horológica con calibre de titanio grado 5 y rotor de geometría variable.',
                'precio' => 7800000,
                'stock' => 3,
                'id_marca' => 4, // Richard Mille
                'id_categoria' => 1,
                'id_subcategoria' => 1,
                'imagen' => 'https://images.unsplash.com/photo-1547996160-71dfabb1a9b1?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Lattafa Asad Eau de Parfum 100ml',
                'sku' => 'LAT-ASD-100',
                'genero' => 'Unisex (Ambos)',
                'descripcion' => 'Fragancia oriental ambarada con pimienta negra, tabaco, café y vainilla. 100% original en cofre de lujo sellado.',
                'precio' => 240000,
                'stock' => 15,
                'id_marca' => 5,
                'id_categoria' => 2,
                'id_subcategoria' => 5,
                'imagen' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Lattafa Khamrah Luxury Edition 100ml',
                'sku' => 'LAT-KHM-100',
                'genero' => 'Unisex (Ambos)',
                'descripcion' => 'Fragancia gourmand celestial con canela, dátiles, praliné y vainilla sobre maderas preciosas.',
                'precio' => 290000,
                'stock' => 10,
                'id_marca' => 5,
                'id_categoria' => 2,
                'id_subcategoria' => 5,
                'imagen' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Gorra Amiri Luxury Bones Trucker Cap',
                'sku' => 'AMR-BNS-BLK',
                'genero' => 'Hombre',
                'descripcion' => 'Gorra snapback de diseñador Amiri con bordado frontal en relieve y broche ajustable.',
                'precio' => 280000,
                'stock' => 12,
                'id_marca' => 6,
                'id_categoria' => 3,
                'id_subcategoria' => 7,
                'imagen' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Billetera Gucci GG Marmont Leather Wallet',
                'sku' => 'GC-MAR-01',
                'genero' => 'Hombre',
                'descripcion' => 'Billetera clásica en piel de becerro con monograma metálico dorado GG y estuche original.',
                'precio' => 650000,
                'stock' => 7,
                'id_marca' => 7,
                'id_categoria' => 3,
                'id_subcategoria' => 8,
                'imagen' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Correa Reversible Coach Signature Leather',
                'sku' => 'COA-REV-38',
                'genero' => 'Hombre',
                'descripcion' => 'Correa reversible en piel refinada con hebilla giratoria níquel pulido.',
                'precio' => 390000,
                'stock' => 9,
                'id_marca' => 8,
                'id_categoria' => 3,
                'id_subcategoria' => 10,
                'imagen' => 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=700&q=80',
            ],
        ];

        foreach ($productosData as $pData) {
            $imagen = $pData['imagen'];
            unset($pData['imagen']);

            $prodId = DB::table('productos')->insertGetId([
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
                'id_producto' => $prodId,
                'url_imagen' => $imagen,
                'principal' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── PEDIDOS DE MUESTRA (EXACTOS AL SCREENSHOT 5) ─────────────
        $pedidosSeed = [
            ['id' => 2, 'id_usuario' => $wilson->id, 'total' => 210000, 'id_estado' => 6, 'created_at' => '2026-08-17 22:46:00'],
            ['id' => 3, 'id_usuario' => $wilson->id, 'total' => 210000, 'id_estado' => 6, 'created_at' => '2026-08-17 22:49:00'],
            ['id' => 4, 'id_usuario' => $wilson->id, 'total' => 480000, 'id_estado' => 3, 'created_at' => '2026-08-19 10:52:00'],
            ['id' => 5, 'id_usuario' => $wilson->id, 'total' => 870000, 'id_estado' => 3, 'created_at' => '2026-08-19 19:56:00'],
            ['id' => 6, 'id_usuario' => $wilson->id, 'total' => 2000000, 'id_estado' => 4, 'created_at' => '2026-08-19 20:02:00'],
            ['id' => 7, 'id_usuario' => $luz->id, 'total' => 1500000, 'id_estado' => 5, 'created_at' => '2026-08-19 22:53:00'],
            ['id' => 8, 'id_usuario' => $luz->id, 'total' => 225000, 'id_estado' => 5, 'created_at' => '2026-08-20 07:32:00'],
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
