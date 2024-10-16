@section('title','Jenis')
@extends('back.layouts.layout')
@section('content')

@if(session('status'))
<div class="row">{{-- Alert --}}
    <div class="col-12 text-center">
        <div class="alert alert-success mt-4">
            {{ session('status') }}
        </div>
    </div>
</div>
@endif
@error('modalName')
<div class="row">{{-- Alert --}}
    <div class="col-12 text-center">
        <div class="alert alert-danger mt-4">
            {{ $message }}
        </div>
    </div>
</div>
@enderror

<div class="row">
    <div class="col-sm-4">
        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center">
                <span>
                    {{-- <i class="fas fa-table-list me-1"></i> --}}
                    <i class="fa-solid fa-circle-plus"></i>
                    Create New Jenis
                </span>
                {{-- <span class="ms-auto">
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fa fa-trash"></i>
                        empty button
                    </a>
                </span> --}}
            </div>
            <div class="card-body">
                <form action="{{route('admin.jenis.createJenis')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                        @error('name') <div class="text-small text-danger">{{$message}}</div> @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="status" id="" class="form-check-input">
                        <label class="form-check-label">Set as Active?</label>
                    </div>
                    <div class="mb-3 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Create Jenis</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center">
                <span>
                    <i class="fas fa-table-list me-1"></i>
                    All Jenis
                </span>
                {{-- <span class="ms-auto">
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fa fa-trash"></i>
                        empty button
                    </a>
                </span> --}}
            </div>
            <div class="card-body">
        
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Number of Article</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Number of Article</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($jenises as $cat)
                        <tr>
                            <td>{{$cat->jenis_id}}</td>
                            <td>{{$cat->jenis_name}}</td>
                            <td>{{$cat->jenis_slug}}</td>
                            <td>{{$cat->getArticleCount()}}</td>
                            <td>
                                <a href="{{route('admin.jenis.changeStatus',$cat->jenis_id)}}" 
                                    class="btn btn-sm {!!$cat->jenis_status == 1 ? 'btn-success' : 'btn-danger'!!}">
                                    {!!$cat->jenis_status == 1 ? 'Active' : 'Passive'!!}
                                </a>
                            </td>
                            <td>
                                <a href="#" title="Edit" jenis-id="{{$cat->jenis_id}}" class="btn btn-sm btn-primary custom-edit-click"><i class="fa fa-pen px-1"></i></a>
                                <a href="#" title="Delete" jenis-count="{{$cat->getArticleCount()}}" jenis-id="{{$cat->jenis_id}}" class="btn btn-sm btn-danger custom-delete-click"><i class="fa fa-trash px-1"></i></a>
                            </td>
                        </tr>
                        @endforeach
                       
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
    Launch static backdrop modal
</button> --}}
  
<!-- Edit Modal -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Jenis</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('admin.jenis.updateJenis')}}" method="post">
            @csrf
            <input type="hidden" name="id" id="jenisid">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="modalName" id="name">
            </div>
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" class="form-control" name="modalSlug" id="slug">
            </div>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
            </form>
      </div>
    </div>
</div> 

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Jenis</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="row">{{-- Alert --}}
                <div class="col-12 text-center">
                    <div class="alert alert-danger mt-4">
                        <span class="" id="articleAlert"></span>
                    </div>
                </div>
            </div>

          <form action="{{route('admin.jenis.deleteJenis')}}" method="post">
            @csrf
            <input type="hidden" name="deleteId" id="deletejenisid">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="modalName" id="deletename" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" class="form-control" name="modalSlug" id="deleteslug" disabled>
            </div>
            <div class="mb-3" id="formSelect">
                <label class="form-label">Select New Jenis</label>
                <select name="newJenisId" class="form-select" id="jenisSelect">
                    
                </select>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="deleteButton" type="submit" class="btn btn-danger">Delete</button>
        </div>
            </form>
      </div>
    </div>
</div> 

@endsection
@section('headScript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('script')
<script>
    // Document hazır olduğunda işlemleri gerçekleştir
    $(document).ready(function() {

        //------ Delete Butonuna click event'i ekle ----------
        $(".custom-delete-click").click(function(event) {
            // Tarayıcıda varsayılan davranışı engelle
            //event.preventDefault();
            
            // AJAX isteği yap
            id = $(this)[0].getAttribute('jenis-id');
            articleCount = $(this)[0].getAttribute('jenis-count');
            $('#articleAlert').html('');
            $('#formSelect').hide();

            if(id==1){
                $('#deleteButton').hide();
                $('#articleAlert').html('This jenis <strong>cannot</strong> be deleted!');
            }
            else{
                $('#deleteButton').show();
                if(articleCount > 0){
                    $('#formSelect').show();
                    $('#articleAlert').html('There are <strong>'+articleCount+'</strong> articles in this jenis. <br>You must <strong><u>select a new jenis</u></strong> for them!')
                }
                else{
                    $('#articleAlert').html('<strong>No articles use</strong> this jenis. Are you sure you want to delete it?')
                }
            }

            //$('#deleteModal').modal('show');

            $.ajax({
                type: "GET", // GET veya POST olarak isteği yapılandırın
                url: "{{route('admin.jenis.getData')}}", // AJAX isteğinin yapılacağı adresi belirtin
                data: {id:id}, // Sunucuya gönderilecek verileri belirtin (isteğe bağlı)
                success: function(response) {
                    // AJAX isteği başarılı olduğunda yapılacak işlemler
                    console.log(response)
                    $('#deletename').val(response.jenis_name);
                    $('#deleteslug').val(response.jenis_slug);
                    $('#deletejenisid').val(response.jenis_id);

                    var selectElement = $('#jenisSelect'); // Select elementini seç
                    selectElement.empty(); // Önce mevcut seçenekleri temizle
                    
                    // AJAX isteğinden dönen dizi elemanlarını döngü ile dolaş
                    response.jenisList.forEach(function(item) {
                        // Her eleman için yeni bir option elemanı oluştur ve seçeneğe ekle
                        if(response.jenis_id != item.jenis_id){
                            var option = $('<option>', {
                                value: item.jenis_id, // Optionun değeri
                                text: item.jenis_name // Optionun metni
                            });
                            selectElement.append(option); // Optionu seçeneğe ekle
                        }
                    });

                    $('#deleteModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // AJAX isteği başarısız olduğunda yapılacak işlemler
                    console.error(error); // Hata konsoluna hata mesajını yazdır
                }
            });
        });
        //------ Edit Butonuna click event'i ekle ----------
        $(".custom-edit-click").click(function(event) {
            // Tarayıcıda varsayılan davranışı engelle
            //event.preventDefault();
            
            // AJAX isteği yap
            id = $(this)[0].getAttribute('jenis-id');
            //console.log(id);

            $.ajax({
                type: "GET", // GET veya POST olarak isteği yapılandırın
                url: "{{route('admin.jenis.getData')}}", // AJAX isteğinin yapılacağı adresi belirtin
                data: {id:id}, // Sunucuya gönderilecek verileri belirtin (isteğe bağlı)
                success: function(response) {
                    // AJAX isteği başarılı olduğunda yapılacak işlemler
                    //console.log(response)
                    $('#name').val(response.jenis_name);
                    $('#slug').val(response.jenis_slug);
                    $('#jenisid').val(response.jenis_id);
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // AJAX isteği başarısız olduğunda yapılacak işlemler
                    console.error(error); // Hata konsoluna hata mesajını yazdır
                }
            });
        });
    });
</script>
    
@endsection