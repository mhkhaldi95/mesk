<?php
use App\User;
use App\Category;
use App\Product;
use App\Client;


use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = "";
        for ($i = 1; $i <= 7; $i++) {
            switch($i){
                case 1 :$name = "رجالي";break;
                case 2 :$name = "حريمي";break;
                case 3 :$name = "أطفال";break;
                case 4 :$name = "كحول";break;
                case 5 :$name = "بخور";break;
                case 6 :$name = "زجاج";break;
                case 7 :$name = "مخمريات";break;



            }
            Category::create([

                'name' => $name,
                ]);

      }
//
//
//
//
//      for ($i = 1; $i <= 50; $i++) {
//
//            Product::create([
//                'name' => "product" .$i,
//
//                'sequenceNo' => '00'.$i,
//                'category_id' => rand(1,3),
//                'whole_stoke' => rand(100,2000),
//                'retail_stoke' => rand(100,2000),
//
//                'purchase_price' => 0.4,
//
//                ]);
//  }
//        Product::create([
//            'name' => 'كحول',
//
//            'sequenceNo' => '00'.$i,
//            'category_id' =>4,
//            'whole_stoke' => rand(1000,2000),
//            'retail_stoke' => rand(1000,2000),
//
//            'purchase_price' => 0.2,
//
//        ]);
//  for ($i = 10000; $i <= 10010; $i++) {
//
//    Product::create([
//        'name' => "product" .$i,
//
//        'sequenceNo' => '00'.$i,
//        'category_id' => rand(5,7),
//        'whole_stoke' => 100,
//        'retail_stoke' => 100,
//
//        'purchase_price' => 1,
//
//        ]);
//}
//  Product::create([
//    'name' => 'عروس',
//
//    'sequenceNo' => '10001',
//    'category_id' =>'5',
//    'whole_stoke' => 100,
//    'retail_stoke' => 100,
//
//    'purchase_price' => '1',
//
//    ]);
//  for ($i = 1; $i <= 100; $i++) {
//      Client::create([
//          'name' => "Client" .$i,
//            'address'=>'100'.$i,
//            'phone'=>'059734304'.$i
//
//          ]);
//}
        $user1 = User::Create([
            'name'=>'misk',
            'email'=>'misk@gmail.com',
            'password'=>bcrypt('111'),
            'image'=>'default-png.png'

        ]);
        // $user = User::Create([
        //     'name'=>'أبو البراء',
        //     'email'=>'abualbaraa@gmail.com',
        //     'password'=>bcrypt('111'),
        //     'image'=>'default-png.png'
        // ]);
        $user1->attachRole('super_admin');
      

       
        //
    }
}

