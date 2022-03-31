<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\İletisim;
use App\Models\Moduller;

class İletisimm extends Controller
{
    function __construct()
    {
        return view()->share('moduller',Moduller::whereDurum(1)->get());
    }
    public function iletisim()
    {
        return view('admin.include.iletisim');
    }
    public function iletisimPost(Request $request)
    {
         $ad_soyad=$request->ad_soyad;
         $email=$request->email;
         $yves=$request->yves;
          İletisim::create([
              'ad_soyad'=>$ad_soyad,
              'email'=>$email,
              'yves'=>$yves,
          ]);
          return redirect()->route('iletisim')->with('basarili','Başarıyla Gönderildi En Yakın Zamanda Sizinle İletişime Geçilecektir.');
    }
}
