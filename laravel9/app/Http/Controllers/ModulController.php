<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Moduller;
use App\Models\Kategoriler;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ModulController extends Controller
{
    function __construct()
    {
        return view()->share('moduller',Moduller::whereDurum(1)->get());
    }
    public function index()
    {
        return view('admin.include.moduller');
    }
    public function modulEkle(Request $request)
    {
       $request->validate([
           'başlık'=>'required|string',
       ]);
       /*1. Kısım Modul Tablous Oluştur*/
       $başlık=$request->başlık;
       $selflink=Str::of($başlık)->slug('-');
       $kontrol=Moduller::whereSelflink($selflink)->first();//bir modul bir kere eklenebilir.
       if($kontrol)
       {
          return redirect()->route('modul-sonuc')->with('hata','Bu Modül Daha Önce Eklenmiştir.');
       }
       else
       {
        Moduller::create([
            'başlık'=>$başlık,
            'selflink'=>$selflink,
        ]);
        /*
        $başlık=$request->başlık;
        $selflink=Str::of($başlık)->slug('-');
        
        $tablo=$request->tablo;
        $sira_no=$request->sira_no;
        *///bu alanların girilmesi zorunlu değildir.
        /*2.Kısım Kategori Kayıt işlemi*/
         Kategoriler::create([
             'başlık'=>$başlık,
             'selflink'=>$selflink,
             'tablo'=>'modul',
             'sira_no'=>1,
         ]);
        /*3.Kısım Dinamik Tablo Oluşturma İşlemi*/
        Schema::create($selflink, function (Blueprint $table) {
           $table->id();
           $table->string("başlık",255);
           $table->string("selflink",255);
           $table->string("resim");
           $table->longText('metin');
           $table->unsignedBigInteger('kategori');
           $table->string("anahtar",255);
           $table->string("description",255);
           $table->enum("durum",[1,2])->default(1);
           $table->integer("sira_no");
           $table->timestamps();
           $table->foreign('kategori')->references('id')->on('kategoriler')->onDelete('cascade');
       });
       /*4.Kısım Model Dosyası Oluşturma*/
       $modelDosyasi='<?php

       namespace App\Models;
       
       use Illuminate\Database\Eloquent\Factories\HasFactory;
       use Illuminate\Database\Eloquent\Model;
       
       class '.ucfirst($selflink).' extends Model
       {   
           use HasFactory;
           protected $table="'.$selflink.'";
           protected $fillable=["id","başlık","selflink","kategori","resim","metin","tablo","anahtar","description","durum","sıra_no","created_at","uptadet_at"];
           
       }';
       File::put(app_path('Models').'/'.ucfirst($selflink).".php",$modelDosyasi);
         

        return redirect()->route('modul-sonuc')->with('basarili','Modülünüz Başarıyla Eklenmiştir.');
       }
        
          
    }
}
