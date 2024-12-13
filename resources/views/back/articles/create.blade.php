@extends('back.layouts.layout')
@section('title','Create Article')

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

<div class="card">
    <div class="card-header">
        <i class="fas fa-edit me-1"></i>
        Create Article
    </div>
    <div class="card-body">
        <form action="{{route('admin.articles.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
                @error('title') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Category</label>
                <select name="category" id="" class="form-select" required>
                    <option value="notSelected">Select a category</option>
                    @foreach ($categories as $cat)
                        <option value="{{$cat->category_id}}" {{ $cat->category_id == 1 ? 'selected' : '' }}>{{$cat->category_name}}</option>
                    @endforeach
                </select>
                @error('category') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Jenis</label>
                <select name="jenis" id="" class="form-select" required>
                    <option value="notSelected">Select a jenis</option>
                    @foreach ($jenises as $cat)
                        <option value="{{$cat->jenis_id}}" {{ $cat->jenis_id == 1 ? 'selected' : '' }}>{{$cat->jenis_name}}</option>
                    @endforeach
                </select>
                @error('jenis') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Pendidikan</label>
                <select name="pendidikan" id="" class="form-select" required>
                    <option value="notSelected">Select a pendidikan</option>
                    @foreach ($pendidikans as $cat)
                        <option value="{{$cat->pendidikan_id}}" {{ $cat->pendidikan_id == 1 ? 'selected' : '' }}>{{$cat->pendidikan_name}}</option>
                    @endforeach
                </select>
                @error('pendidikan') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Tingkat</label>
                <select name="tingkat" id="" class="form-select" required>
                    <option value="notSelected">Select a tingkat</option>
                    @foreach ($tingkats as $cat)
                        <option value="{{$cat->tingkat_id}}" {{ $cat->tingkat_id == 1 ? 'selected' : '' }}>{{$cat->tingkat_name}}</option>
                    @endforeach
                </select>
                @error('tingkat') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Upload Picture</label>
                <input type="file" name="image" accept="image/*" class="form-control" >
                @error('image') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <div id="editor" style="height: 14em"></div>
                <input type="hidden" name="content" id="content">
                @error('content') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="status" id="" class="form-check-input">
                <label class="form-check-label">Set as Active?</label>
            </div>
            <div class="mb-3 d-grid gap-2">
                <button type="submit" class="btn btn-primary">Create Article</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('headScript')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.snow.css" rel="stylesheet" />
@endsection
    
    
@section('script')
    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
    
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }],
                [{ 'font': [] }],
                [{ 'size': ['small', 'medium', 'large', 'huge'] }],
                [{ 'align': [] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image', 'blockquote', 'code-block'],
                [{ 'direction': 'rtl' }],
                ['link'],
                ['undo', 'redo']  // Optional undo/redo buttons
            ]
        }
    });

    // Custom Image Handler
    function imageHandler() {
        const url = prompt('Enter the image URL');
        if (url) {
            const range = quill.getSelection();
            quill.insertEmbed(range.index, 'image', url);
            const image = document.querySelector(`img[src="${url}"]`);
            if (image) {
                image.style.height = '700px';
                image.style.width = 'auto';
                image.style.display = 'block';
                image.style.marginLeft = 'auto';
                image.style.marginRight = 'auto';
                // Optionally add margin for spacing
                image.style.marginTop = '20px';
                image.style.marginBottom = '20px';
            }
        }
    }


    // Form submit edildiğinde, Quill editöründeki HTML içeriğini gizli bir input alanına ekleyin
    var form = document.querySelector('form');

    form.onsubmit = function() {
        var content = document.querySelector('input#content');
        content.value = quill.root.innerHTML;
    };

    </script>

@endsection