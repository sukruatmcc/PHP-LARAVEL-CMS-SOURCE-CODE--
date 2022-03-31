@extends("admin.tema")
@section("master")
@section("css")
@endsection

<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="col-lg-12">
                    @if(session('basarili'))
                    <div class="alert alert-success">{{ session('basarili') }}</div>
                  @endif
                  @if(session('hata'))
                    <div class="alert alert-danger">{{ session('hata') }}</div>
                  @endif
                  
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Modül Ekleme</h4>
                            <p class="text-muted">Web siteniz için otomatik tablo ve crud işlemleri yapar</p>
                            <div class="basic-form">
                               
                                <form action="{{ route('modul_ekle') }}" class="form-inline" method="POST">
                                    @csrf
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label class="sr-only">Modül İsmi</label>
                                        <input type="text" class="form-control" name="başlık" placeholder="Modül İsmi">
                                    </div>
                                    <button type="submit" class="btn btn-dark mb-2">Modül Oluştur</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

@endsection
@section("js")
@endsection

