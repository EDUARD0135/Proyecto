<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;

class ProductoFactory extends Factory
{
   
    public function definition(): array
    {

        $image1 = 'https://thefoodtech.com/wp-content/uploads/2020/05/Golosinas-828x548.jpg';
        $image2 = 'https://ansimar.edu.pe/wp-content/uploads/2020/12/los-mejores-accesorios-de-moda-980x586.jpg';
        $image3 = 'https://www.mundodeportivo.com/alfabeta/hero/2023/07/nezuko-2_x16_drawing.jpg?width=1200&aspect_ratio=16:9';
        $image4 = 'https://media.istockphoto.com/id/1148039529/es/foto/el-concepto-de-mesa-de-aperitivos-del-medio-oriente-%C3%A1rabe-o-mediterr%C3%A1neo.jpg?s=612x612&w=0&k=20&c=MqyXYOcyym138KNJLhDRGGToDF0XzY0kTj3GoVwJd0w=';
       
        return [
           'categoria'=>fake()->randomElement(['Camisas', 'Pantalones', 'Zapatos','Dulces','Postres','Variado','llaveros','Pulseras','Collares']),
           'nombre'=>fake()->text(),
           'precio'=>fake()->numberBetween(10, 100),
           'descripcion'=>fake()->text(),
           'Imagen'=>fake()->randomElement([$image1, $image2, $image3, $image4]),
           'usuario_id'=>fake()->numberBetween(2, 20),

        ];
    }
}
