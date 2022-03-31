@extends("admin.tema")
@section("master")
@section('title') İletişim @endsection
@section("css")
<link href="{{ asset('admin') }}/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
          @if($errors -> any())
          <div class="alert alert-danger">Bu alan zorunludur!
              <ul>
                  @foreach ( $errors->all() as $danger )
                  <li>{{ $danger }}</li>
                      
                  @endforeach
              </ul>
    
          </div>
              
          @endif
            @if(session('basarili'))
                    <div class="alert alert-success">{{ session('basarili') }}</div>
                  @endif
                  @if(session('hata'))
                    <div class="alert alert-danger">{{ session('hata') }}</div>
                  @endif>
            <div class="container-fluid"> 
               <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d391768.355431781!2d32.48257158608294!3d39.90356622124967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d347d520732db1%3A0xbdc57b0c0842b8d!2sAnkara%2C+T%C3%BCrkiye!5e0!3m2!1str!2sus!4v1556530231994!5m2!1str!2sus" width="100%" height="435" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <form  action="{{ route('iletisimpost') }}" method="POST">
                        @csrf
                        <div class="form-group">
                          <label>Kullanıcı Adı</label>
                          <input type="text" class="form-control" name="ad_soyad"  placeholder="kullanıcı adı" required>
                        </div>
                        <div class="form-group">
                          <label>E-Mail</label>
                          <input type="email" class="form-control" name="email" placeholder="e-mail" required>
                        </div>
                        <div class="form-group">
                          <label>Mesaj</label>
                          <textarea type="mesaj"  class="form-control" name="yves" placeholder="Mesaj..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gönder</button>
                      </form>
                </div>
               </div>
                    
                </div>
        </div>  
                <!-- Veri Çekme İşlemleri-->
                
               
           
        <!--**********************************
            Content body end
        ***********************************-->


@endsection
@section("js")
    <script src="{{ asset('admin') }}/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('admin') }}/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('admin') }}/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
@endsection

