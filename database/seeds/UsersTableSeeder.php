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
        for ($i = 1; $i <= 5; $i++) {
            switch($i){
                case 1 :$name = "رجال";break;
                case 2 :$name = "حريمي";break;
                case 3 :$name = "بخور";break;
                case 4 :$name = "كحول";break;
                case 5 :$name = "زجاج";break;


            }
            Category::create([

                'name' => $name,
                ]);
               
      }
    

     

      for ($i = 1; $i <= 2000; $i++) {
          
            Product::create([
                'name' => "product" .$i,

                'sequenceNo' => '00'.$i,
                'category_id' => rand(1,2),
                'whole_stoke' => 100,
                'retail_stoke' => 100,

                'purchase_price' => 5,

                ]);
  }
  Product::create([
    'name' => 'عروس',

    'sequenceNo' => '10001',
    'category_id' =>'5',
    'whole_stoke' => 100,
    'retail_stoke' => 100,

    'purchase_price' => '2',

    ]);
  for ($i = 1; $i <= 2000; $i++) {
      Client::create([
          'name' => "Client" .$i,
            'address'=>'100'.$i,
            'phone'=>'059734304'.$i

          ]);
}
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

