@extends("admin.tema")
@section("master")
@section("css")
<link href="{{ asset('admin') }}/plugins/summernote/dist/summernote.css" rel="stylesheet">
@endsection

<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
               <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $modulBilgisi->başlık }}</h4>
                            <p class="text-muted m-b-15 f-s-12">
                            <div class="basic-form">
                                <form action="{{ route('eklepost',$modulBilgisi->selflink) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                             <select class="form-control input-default" name="kategori">
                                                @if($kategoriBilgisi)
                                                @foreach ($kategoriBilgisi as $kategori )
                                                    <option value="{{ $kategori->id }}">{{ stripslashes($kategori->başlık) }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <label>Başlık</label>
                                        <input type="text" class="form-control input-default" placeholder="Başlık" name="başlık" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Açıklama</label>
                                        <textarea class="summernote" name="metin">
 
                                        </textarea>
                                             
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Resim</label>
                                        <input type="file" class="form-control input-flat" placeholder="Resim Seçiniz" name="resim">
                                    </div>
                                     <div class="form-group">
                                        <label>Anahtar</label>
                                        <input type="text" class="form-control input-flat" placeholder="Anahtar" name="anahtar" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control input-flat" placeholder="Description" name="description" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Sıra No</label>
                                        <input type="number" class="form-control input-default" placeholder="Sıra No" name="sira_no" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="Kaydet" name="ilet">
                                    </div>
                                   
                                
                                </form>
                            </div>
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
    <script src="{{ asset('admin') }}/plugins/summernote/dist/summernote.min.js"></script>
    <script src="{{ asset('admin') }}/plugins/summernote/dist/summernote-init.js"></script>
@endsection

