@extends("admin.tema")
@section("master")
@section('title') Yorum İşlemleri @endsection
@section("css")
<link href="{{ asset('admin') }}/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid"> 
                @if(session('basarili'))
                <div class="alert alert-success">{{ session('basarili') }}</div>
              @endif
              @if(session('hata'))
                <div class="alert alert-danger">{{ session('hata') }}</div>
              @endif
                <div class="row">
                    <form action="{{ route('yorumpost') }}" method="POST">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Kullanıcı adı</label>
                          <input type="text" value="{{ $veriler->kullanici_adi }}" name="kullanici_adi" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Kullanıcı Adı Giriniz..." required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Yorum Ekle</label>
                            <textarea class="form-control" value="{{ $veriler->yorum }}" rows="5" id="comment" style="width:900px; height:150px" name="yorum">{{ $veriler->yorum }}</textarea>
                          </div>
                            </div>
                        </div>
                      </form>
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

