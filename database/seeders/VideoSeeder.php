<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
      Video::create([
        'name' => 'تعليم نطق الألوان للأطفال',
        'image' => 'http://127.0.0.1:8000/image/1685741241.jpg',
        'path' => 'https://youtu.be/U7Lbv94OFD4',
        'time' =>'00:13:35',
        'category_id' => '11'
    ]);
    Video::create([
        'name' => 'سؤال وجواب للاطفال',
        'image' => 'http://127.0.0.1:8000/image/1685741571.jpg',
        'path' => 'https://youtu.be/QEVQ-WEgWbQ',
        'time' =>'00:7:12',
        'category_id' => '11'
    ]);
    Video::create([
        'name' => 'تعليم الحواس الخمسة',
        'image' => 'http://127.0.0.1:8000/image/1685742295.jpg',
        'path' => 'https://youtu.be/Z6EePOupLXg',
        'time' =>'00:3:05',
        'category_id' => '11'
    ]);
    Video::create([
        'name' => 'قطار الحيوانات l تعلم أسماء الحيوانات والطيور مع أصواتها',
        'image' => 'http://127.0.0.1:8000/image/1685742150.jpg',
        'path' => 'https://youtu.be/SdbK_nIaIfA',
        'time' =>'00:5:00',
        'category_id' => '11'
    ]);
    Video::create([
        'name' => 'تعليم أسماء الفواكه وفوائدها للأطفال',
        'image' => 'http://127.0.0.1:8000/image/1685451639.jpg',
        'path' => 'https://youtu.be/HvM6HbgPelc',
        'time' =>'00:2:23',
        'category_id' => '11'
    ]);
    Video::create([
        'name' => 'العاب تنمية مهارات التفكير والتركيز للاطفال |العاب ذكاء للاطفال',
        'image' => 'image/1685741456.jpg',
        'path' => 'https://youtu.be/oAZ0fc27qBY',
        'time' =>'00:10:24',
        'category_id' => '11'
    ]);
    Video::create([
        'name' => 'أغنية حروف اللغة الانجليزية ABC',
        'image' => 'image/1685451418.jpg',
        'path' => 'https://youtu.be/yXBHeTsvK9w',
        'time' =>'00:1:21',
        'category_id' => '13'
    ]);
    Video::create([
        'name' => 'انشودة الحروف العربية',
        'image' => 'image/1685451730.jpg',
        'path' => 'https://youtu.be/NBI6uEFWVG8',
        'time' =>'00:2:42',
        'category_id' => '13'
    ]);
    Video::create([
        'name' => 'أغنية الارقام',
        'image' => 'image/1685451277.jpg',
        'path' => 'https://youtu.be/mbByy00e-S0',
        'time' =>'00:3:01',
        'category_id' => '13'
    ]);
    Video::create([
        'name' => 'هل يمكنك أن تقول ماما؟ | أغاني تعليمية للأطفال باللغة العربية | Little Angel Arabic',
        'image' => 'image/1685451358.jpg',
        'path' => 'https://youtu.be/UogyhHl0VJs',
        'time' =>'00:2:54',
        'category_id' => '13'
    ]);
    Video::create([
        'name' => 'أغنية الخضار في المزرعة - الخضروات مفيدة | أغاني تعليمية للأطفال باللغة العربية | Little Angel',
        'image' => 'image/1685451484.jpg',
        'path' => 'https://youtu.be/zth3vO345po',
        'time' =>'00:3:16',
        'category_id' => '13'
    ]);
    Video::create([
        'name' => 'أغنية محمد نبينا ﷺ',
        'image' => 'image/1685741097.jpg',
        'path' => 'https://youtu.be/dNdM6XvK8do',
        'time' =>'00:2:11',
        'category_id' => '13'
    ]);
        Video::create([
         'name'=> 'النظافة من الايمان " نصيحة الامام البخاري للطفل عمر عن النظافة',
         'image'=>'image/1685822853.jpg',
          'path'=>'https://youtu.be/4kknUHekG7w',
          'time'=>'00:10:02',
          'category_id'=>'10'
        ]);
        Video::create([
            'name'=> 'قصص اطفال - الفأر الطماع',
            'image'=>'image/1685822597.jpg',
             'path'=>'https://youtube.com/watch?v=nXqmndKLkqA&feature=share',
             'time'=>'00:7:49',
             'category_id'=>'10'
           ]);
           Video::create([
            'name'=> 'قصص اطفال -  حفظ النعمة ',
            'image'=>'image/1685823047.jpg',
             'path'=>'https://youtu.be/j4eoB5RtP9Q',
             'time'=>'00:13:27',
             'category_id'=>'10'
           ]);
           Video::create([
            'name'=> 'البطة القبيحة ',
            'image'=>'image/1685822016.jpg',
             'path'=>'https://youtu.be/w0NMPl-YJuo',
             'time'=>'00:5:14',
             'category_id'=>'10'
           ]);

           Video::create([
            'name'=> ' قصة أصحاب الفيل للأطفال  ',
            'image'=>'image/1685822507.jpg',
             'path'=>'https://youtu.be/YcwgwTUkxsM',
             'time'=>'00:3:50',
             'category_id'=>'10'
           ]);
           Video::create([
            'name'=> ' تعليم الأطفال  آداب الطعام  ',
            'image'=>'image/1685822081.jpg',
             'path'=>'https://youtu.be/YcwgwTUkxsM',
             'time'=>'00:2:58',
             'category_id'=>'10'
           ]);
           Video::create([
            'name'=> '  الراعي الكذاب ',
            'image'=>'image/1685822280.jpg',
             'path'=>'https://youtu.be/OFPNLwtBDVE',
             'time'=>'00:2:40',
             'category_id'=>'12'
           ]);
           Video::create([
            'name'=> ' في منزل أنثى السنجاب دق دق الباب ',
            'image'=>'image/1685822740.jpg',
             'path'=>'https://youtu.be/Gmhk7mWG050',
             'time'=>'00:2:31',
             'category_id'=>'12'
           ]);
           Video::create([
            'name'=> ' أغنية الفواكه و الخضروات - يمي يمي هم هم ',
            'image'=>'image/1685822400.jpg',
             'path'=>'https://youtu.be/IStGvzmeBJ0',
             'time'=>'00:1:57',
             'category_id'=>'12'
           ]);
           Video::create([
            'name'=> ' babyshark ',
            'image'=>'image/1685821763.jpg',
             'path'=>'https://youtu.be/XqZsoesa55w',
             'time'=>'00:2:16',
             'category_id'=>'12'
           ]);
           Video::create([
            'name'=> ' wheels on bus song ',
            'image'=>'image/1685822668.jpg',
             'path'=>'https://youtu.be/xk3pJVYI5gY',
             'time'=>'00:2:16',
             'category_id'=>'12'
           ]);
           
           Video::create([
            'name'=> 'Lets Take a Bath ',
            'image'=>'image/1685822356.jpg',
             'path'=>'https://youtu.be/AEyzSO_sX-Q',
             'time'=>'00:3:41',
             'category_id'=>'12'
           ]);

    }
}
