<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moduller;
use App\Models\Yorum;
use App\Models\Ayarlar;
use App\Models\Kategoriler;
use Illuminate\Support\Str;

class AdminYonetim extends Controller
{
    function __construct()
    {
        return view()->share('moduller',Moduller::whereDurum(1)->get());
    }
    public function index()
    {
        return view('admin.include.home');
    }
    public function liste($modul)
    {
        $dinamikModul=Moduller::whereDurum(1)->whereSelflink($modul)->first();//kontrol ettirdiğimiz modül ismi ve makalesse açılmasın.
        //bu if kontrolü routede kategorinin ismi tam olarak yazılıp yazılmamasını kontrol eder
        if($dinamikModul)//ve tam olarak yazılmışşsa
        {
            $dinamikModel="App\Models\\".ucfirst($dinamikModul->selflink);//ilgili moduldeki veritabanına bağlanma.
            $veriler=$dinamikModel::get();//verilerin getirilmesini istiyoruz burada.
            return view("admin.include.liste",compact(["veriler","dinamikModul"]));
        }
        else//tam olararak yazılmamşsa
        {
             return redirect()->route("home");
        }
        
    }
    public function ekle($modul)
    {
        $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();//kontrol ettirdiğimiz modül ismi ve makalesse açılmasın.
        $kategoriBilgisi=Kategoriler::whereSelflink($modul)->whereTablo('modul')->get();//dinamik kategori tanımlama
        if($modulBilgisi && $kategoriBilgisi)
        {
            return view('admin.include.ekle',compact(['modulBilgisi','kategoriBilgisi']));
        }
        else
        {
            return redirect()->route('home');
        }
    }
    public function eklePost($modul, Request $request)
    {
        $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
        if($modulBilgisi)
        {
            $modelDosyaAdi=ucfirst($modulBilgisi->selflink);//dosyas adı tanımlaması. ve büyük harf olması
            $request->validate([
                'başlık'=>'required|string',
                'kategori'=>'required',
                'anahtar'=>'required',
                'description'=>'required',
            ]);
            $başlık=$request->başlık;
            $selflink=Str::of($başlık)->slug('-');
            $metin=$request->metin;
            $kategori=$request->kategori;
            $anahtar=$request->anahtar;
            $description=$request->description;
            $sira_no=$request->sira_no;
            //bu bölümde dinamik dosya kaydetme işlemi olcaktır.
            $dinamikModel="App\Models\\".$modelDosyaAdi;//dosya yolu tanımlama.ve model dosyasına erişim.
            $resimDosyasi=$request->file('resim');//dosyaya istek gönderme ve nesneyi tanıtlatma
            if(isset($resimDosyasi))
            {
               $resim=uniqid().".".$resimDosyasi->getClientOriginalExtension(); 
               $resimDosyasi->move(public_path('images/'.$modulBilgisi->selflink),$resim);
               $kaydet=$dinamikModel::create([//kaydetme işlemi
                "başlık"=>$başlık,
                "selflink"=>$selflink,
                "metin"=>$metin,
                "kategori"=>$kategori,
                "resim"=>$resim,
                "anahtar"=>$anahtar,
                "description"=>$description,
                "sira_no"=>$sira_no,
               ]);
            }
            else
            {
                $kaydet=$dinamikModel::create([//kaydetme işlemi
                    "başlık"=>$başlık,
                    "selflink"=>$selflink,
                    "metin"=>$metin,
                    "kategori"=>$kategori,
                    "anahtar"=>$anahtar,
                    "description"=>$description,
                    "sira_no"=>$sira_no,
                ]);
                
            }
             
           } 
        else
        {
            return redirect()->route('home');
        }
    }
   //silme ve düzenleme işlemmleri
   public function duzenle($modul,$id)
   {
       $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
       $kategoriBilgisi=Kategoriler::whereSelflink($modul)->whereTablo('modul')->get();
       if($modulBilgisi && $kategoriBilgisi)
       {
           $modelDosyaAdi=ucfirst($modulBilgisi->selflink);
           $dinamikModel="App\Models\\".$modelDosyaAdi;
           $veriler=$dinamikModel::whereId($id)->first();
           return view('admin.include.duzenle',compact(['modulBilgisi','kategoriBilgisi','veriler']));
       }
       else
       {
           return redirect()->route('home');
       }
   }
   public function duzenlePost($modul, $id, Request $request)
   {
       $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
       if($modulBilgisi)
       {
           $modelDosyaAdi=ucfirst($modulBilgisi->selflink);//dosyas adı tanımlaması. ve büyük harf olması
           $request->validate([
               'başlık'=>'required|string',
               'kategori'=>'required',
               'anahtar'=>'required',
               'description'=>'required',
           ]);
           $başlık=$request->başlık;
           $selflink=Str::of($başlık)->slug('-');
           $metin=$request->metin;
           $kategori=$request->kategori;
           $anahtar=$request->anahtar;
           $description=$request->description;
           $sira_no=$request->sira_no;
           //bu bölümde dinamik dosya kaydetme işlemi olcaktır.
           $dinamikModel="App\Models\\".$modelDosyaAdi;//dosya yolu tanımlama.ve model dosyasına erişim.
           $resimDosyasi=$request->file('resim');//dosyaya istek gönderme ve nesneyi tanıtlatma
           if(isset($resimDosyasi))
           {
              $resim=uniqid().".".$resimDosyasi->getClientOriginalExtension(); 
              $resimDosyasi->move(public_path('images/'.$modulBilgisi->selflink),$resim);
              $kaydet=$dinamikModel::whereId($id)->update([//kaydetme işlemi
               "başlık"=>$başlık,
               "selflink"=>$selflink,
               "metin"=>$metin,
               "kategori"=>$kategori,
               "resim"=>$resim,
               "anahtar"=>$anahtar,
               "description"=>$description,
               "sira_no"=>$sira_no,
              ]);
           }
           else
           {
               $kaydet=$dinamikModel::whereId($id)->update([//kaydetme işlemi
                   "başlık"=>$başlık,
                   "selflink"=>$selflink,
                   "metin"=>$metin,
                   "kategori"=>$kategori,
                   "anahtar"=>$anahtar,
                   "description"=>$description,
                   "sira_no"=>$sira_no,
               ]);
               
               
           }
              return redirect()->route('liste',[$modulBilgisi->selflink,$id])->with('basarili','Başarıyla Güncellendi');
          } 
       else
       {
           return redirect()->route('home');
       }
   }
   
   //silme işlemi
   public function sil($modul,$id)
   {
       $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
       $modelDosyaAdi=ucfirst($modulBilgisi->selflink);
        $dinamikModel="App\Models\\".$modelDosyaAdi;
        $veriler=$dinamikModel::whereId($id)->first();
       if($modulBilgisi )
       {
           
          $silme_islemi=$dinamikModel::whereId($id)->delete();
          return redirect()->route('liste',[$modulBilgisi->selflink,$id])->with('basarili','Başarıyla silinmiştir');
       }
       else
       {
           return redirect()->route('home');
       }
   }
   
   //durum işlemlerini ayarlama
   public function durum($modul,$id)
   {
       $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
       $kategoriBilgisi=Kategoriler::whereSelflink($modul)->whereTablo('modul')->get();
       if($modulBilgisi && $kategoriBilgisi)
       {
           $modelDosyaAdi=ucfirst($modulBilgisi->selflink);
           $dinamikModel="App\Models\\".$modelDosyaAdi;
           $veriler=$dinamikModel::whereId($id)->first();
           if($veriler)
           {
               if($veriler->durum==1){$durum=2;}else{$durum=1;}
               $kaydet=$dinamikModel::whereId($id)->update([//durum değişitirme işlemi
                "durum"=>$durum,
            ]);
             return redirect()->back()->with('basarili','Durumunuz başarıyla güncellendi');  
           }
           else
           {
            return redirect()->back();
           }
       }
       else
       {
           return redirect()->route('home');
       }
   }
   // ayar işlemleri
   public function ayarlar()
   {
      $veriler=Ayarlar::whereId(1)->first();
      return view('admin.include.ayarlar',compact('veriler'));
   }
   public function ayarPost(Request $request)
   {
    $request->validate([
        'title'=>'required|string',
        'keywords'=>'required',
        'description'=>'required',
    ]);
    $title=$request->title;
    $keywords=$request->keywords;
    $description=$request->description;
    $bakimmodu=$request->bakimmodu;
    $ilkguncelleme=Ayarlar::whereId(1)->update([//kaydetme işlemi
        "title"=>$title,
        "keywords"=>$keywords,
        "description"=>$description,
        "bakimmodu"=>$bakimmodu,
    ]);
    $logoDosyasi=$request->file('logo');
    if(isset($logoDosyasi))
    {
        $logo=uniqid().".".$logoDosyasi->getClientOriginalExtension();
        $logoDosyasi->move(public_path('images'),$logo);
        $ikinciguncelleme=Ayarlar::whereId(1)->update([//kaydetme işlemi
            "logo"=>$logo,
        ]);
    }
    return redirect()->route("ayar")->with('basarili','İşleminiz başarıyla kaydedildi');  
    
   }
   public function yorum()
   {
       return view('admin.include.yorum');
   }
    
   public function yorumPost(Request $request)
   {
       $request->validate([
           'kullanici_adi'=>'required|string',
           'yorum'=>'required|string',
       ]);
        $kullanici_adi=$request->kullanici_adi;
        $yorum=$request->yorum;
         Yorum::create([
             'kullanici_adi'=>$kullanici_adi,
             'yorum'=>$yorum,
         ]);
           return redirect()->route('yorumlarr')->with('basarili','yorumunuz başarılı bir şekilde eklenmişitir');
   }

   public function yorumlar()
   {
            $veriler=Yorum::get();//verilerin getirilmesini istiyoruz burada.
            return view("admin.include.yorumlar",compact(["veriler"]));
   }
    /*
    $dinamikModul=Moduller::first();//kontrol ettirdiğimiz modül ismi ve makalesse açılmasın.
        //bu if kontrolü routede kategorinin ismi tam olarak yazılıp yazılmamasını kontrol eder
        if($dinamikModul)//ve tam olarak yazılmışşsa
        {
            $veriler=Yorum::first();//verilerin getirilmesini istiyoruz burada.
            return view("admin.include.yorumlar",compact(["veriler","dinamikModul"]));
        }
        else//tam olararak yazılmamşsa
        {
             return redirect()->route("home");
        }
    */ 
    public function goster()
    {
        $gosterBilgisi=Yorum::first();
        if($gosterBilgisi)
        {
            $veriler=Yorum::first();
            return view('admin.include.goster',compact(['gosterBilgisi','veriler']));
        }
        else
        {
            return redirect()->route('home');
        }
    }
    public function yorumSil($id)
   {
       $modulBilgisi=Yorum::whereId($id)->first();
       if($modulBilgisi )
       {
          $silme_islemi=Yorum::whereId($id)->delete();
          return redirect()->route('yorumlarr',[$modulBilgisi->$id])->with('basarili','Başarıyla silinmiştir');
       }
       else
       {
           return redirect()->route('home');
       }
   }
   
}
