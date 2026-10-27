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
            ['nombre' => 'Rolex', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Richard Mille', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Patek Philippe', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Audemars Piguet', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Lattafa', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Amiri', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gucci', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Coach', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sin marca', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Usuario Administrador
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

        // Usuario Cliente Demo (HU-01, HU-02)
        $clienteDemo = User::create([
            'name' => 'Carlos',
            'apellido' => 'Gómez',
            'cedula' => '1020304050',
            'email' => 'cliente@jcurban.com',
            'password' => Hash::make('Cliente@2025'),
            'id_rol' => 2,
            'telefono' => '3157894561',
            'direccion' => 'Carrera 43A # 1 Sur - 50 Edificio Luxe',
            'barrio' => 'El Poblado',
            'ciudad' => 'Medellín',
            'activo' => true,
        ]);

        // ─── PRODUCTOS DE MUESTRA CON FOTOS DE ALTA RESOLUCIÓN ────────
        $productosData = [
            // RELOJES (Categoría 1)
            [
                'nombre' => 'Rolex Submariner Date Gold Edition',
                'descripcion' => "Reloj de alta gama con caja de acero Oystersteel y oro amarillo de 18 quilates. Esfera color negro con visualización Chromalight de alta legibilidad.\n\n• Movimiento automático calibre 3235\n• Resistencia al agua: 300 metros\n• Cristal de zafiro resistente a rayaduras con lente Cyclops\n• Incluye estuche original y garantía oficial de 6 meses en maquinaria JC URBAN.",
                'precio' => 4500000,
                'stock' => 5,
                'id_marca' => 1, // Rolex
                'id_categoria' => 1, // Relojes
                'id_subcategoria' => 1, // Alta gama
                'imagen' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Richard Mille RM 11-03 Flyback Chronograph',
                'descripcion' => "El RM 11-03 es una obra maestra de la ingeniería horológica inspirada en los monoplazas de Fórmula 1. Su calibre flyback de titanio grado 5 ofrece una precisión sin rival.\n\n• Caja en carbono TPT y titanio\n• Correa de caucho de alta densidad\n• Indicador de fecha sobredimensionada y mes a las 4:30\n• 6 meses de garantía JC URBAN.",
                'precio' => 7800000,
                'stock' => 3,
                'id_marca' => 2, // Richard Mille
                'id_categoria' => 1,
                'id_subcategoria' => 1,
                'imagen' => 'https://images.unsplash.com/photo-1547996160-71dfabb1a9b1?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Patek Philippe Nautilus 5711 Steel & Blue',
                'descripcion' => "Icono atemporal de la elegancia deportiva de lujo. Bisel octogonal redondeado y esfera con grabado horizontal azul noche.\n\n• Calibre 26-330 S C extraplano\n• Brazalete de acero integrado pulido a mano\n• Cierre desplegable Nautilus\n• Garantía de 6 meses en maquinaria.",
                'precio' => 6200000,
                'stock' => 4,
                'id_marca' => 3, // Patek Philippe
                'id_categoria' => 1,
                'id_subcategoria' => 1,
                'imagen' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Audemars Piguet Royal Oak Offshore Chrono',
                'descripcion' => "Diseño audaz y vanguardista para los amantes del poder y la sofisticación. Esfera con diseño 'Méga Tapisserie' negro y pulsadores cerámicos.\n\n• Cronógrafo automático calibre 3126\n• Reserva de marcha de 50 horas\n• Garantía de 6 meses JC URBAN.",
                'precio' => 5900000,
                'stock' => 6,
                'id_marca' => 4, // Audemars Piguet
                'id_categoria' => 1,
                'id_subcategoria' => 2,
                'imagen' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=700&q=80',
            ],

            // PERFUMES (Categoría 2)
            [
                'nombre' => 'Lattafa Asad Eau de Parfum 100ml',
                'descripcion' => "Fragancia oriental ambarada icónica. Una apertura explosiva de pimienta negra, tabaco y piña, seguida de un corazón cálido de café, pachulí y benjuí con notas de fondo de vainilla y ámbar seco.\n\n• Concentración: Eau de Parfum (alta fijación +8h)\n• Presentación: Frasco de lujo 100ml sellado con holograma\n• 100% Original garantizado.",
                'precio' => 240000,
                'stock' => 15,
                'id_marca' => 5, // Lattafa
                'id_categoria' => 2,
                'id_subcategoria' => 5, // Originales
                'imagen' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Lattafa Khamrah Luxury Edition 100ml',
                'descripcion' => "Una fragancia gourmand celestial con notas de canela, nuez moscada, dátiles dulces, praliné y haba tonka sobre una base de maderas preciosas.\n\n• Ideal para eventos nocturnos y clima templado\n• Excelente estela y duración de hasta 12 horas\n• Producto 100% original en cofre de lujo.",
                'precio' => 290000,
                'stock' => 10,
                'id_marca' => 5,
                'id_categoria' => 2,
                'id_subcategoria' => 5,
                'imagen' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Sauvage Elixir Parfum Concentré 60ml',
                'descripcion' => "Una concentración extraordinaria enriquecida con especias embriagadoras, lavanda hecha a medida y un licor de maderas ricas que firman una estela única y poderosa.\n\n• Notas olfativas: Cardamomo, nuez moscada, canela, regaliz y pachulí\n• Envase azul noche con acabado de frasco de cristal lacado.",
                'precio' => 720000,
                'stock' => 8,
                'id_marca' => 9, // Sin marca / Diseñador
                'id_categoria' => 2,
                'id_subcategoria' => 6, // Alta gama
                'imagen' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=700&q=80',
            ],

            // ACCESORIOS (Categoría 3)
            [
                'nombre' => 'Gorra Amiri Luxury Bones Trucker Cap',
                'descripcion' => "Gorra snapback de diseñador Amiri con bordado frontal de alta definición en relieve. Malla trasera de ventilación premium y broche regulable.\n\n• Material: Algodón premium y malla sintética\n• Interior forrado con marquilla de autenticidad\n• Talla única ajustable.",
                'precio' => 280000,
                'stock' => 12,
                'id_marca' => 6, // Amiri
                'id_categoria' => 3,
                'id_subcategoria' => 7, // Gorras
                'imagen' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Billetera Gucci GG Marmont Leather Wallet',
                'descripcion' => "Billetera clásica de piel becerro con monograma metálico dorado GG. Múltiples ranuras para tarjetas de crédito y compartimento para billetes forrado en seda moiré.\n\n• Fabricada en cuero genuino italiano\n• 8 ranuras para tarjetas y 2 bolsillos para billetes\n• Incluye estuche y funda guardapolvo.",
                'precio' => 650000,
                'stock' => 7,
                'id_marca' => 7, // Gucci
                'id_categoria' => 3,
                'id_subcategoria' => 8, // Billeteras
                'imagen' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=700&q=80',
            ],
            [
                'nombre' => 'Correa Reversible Coach Signature Leather',
                'descripcion' => "Correa reversible en piel refinada y lona con el estampado Signature de Coach. Hebilla metálica giratoria en acabado níquel pulido.\n\n• Ancho: 38 mm\n• Longitud ajustable a cualquier talla\n• Reversible: Doble estilo en un solo accesorio.",
                'precio' => 390000,
                'stock' => 9,
                'id_marca' => 8, // Coach
                'id_categoria' => 3,
                'id_subcategoria' => 10, // Correas
                'imagen' => 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=700&q=80',
            ],
        ];

        foreach ($productosData as $pData) {
            $imagen = $pData['imagen'];
            unset($pData['imagen']);

            $prodId = DB::table('productos')->insertGetId([
                'nombre' => $pData['nombre'],
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
    }
}
