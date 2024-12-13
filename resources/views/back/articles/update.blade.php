@extends('back.layouts.layout')
@section('title','Update Article')

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
    <div class="card-header d-flex align-items-center">
        <span>
            <i class="fas fa-edit me-1"></i>
            Update Article
        </span>
        <span class="ms-auto">
            <a href="{{route('admin.articles.index')}}" class="btn btn-outline-primary">
                <i class="fa fa-eye"></i>
                All Articles
            </a>
        </span>
    </div>
    <div class="card-body">
        <form action="{{route('admin.articles.update',$article->article_id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="" class="form-label">Title</label>
                <input type="text" name="title" value="{{$article->article_title}}" class="form-control" required>
                @error('title') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Category</label>
                <select name="category" id="" class="form-select" required>
                    <option value="notSelected">Select a category</option>
                    @foreach ($categories as $cat)
                        <option {{$article->category_id == $cat->category_id ? 'selected' : ''}} value="{{$cat->category_id}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
                @error('category') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Jenis</label>
                <select name="jenis" id="" class="form-select" required>
                    <option value="notSelected">Select a jenis</option>
                    @foreach ($jenises as $cat)
                        <option {{$article->jenis_id == $cat->jenis_id ? 'selected' : ''}} value="{{$cat->jenis_id}}">{{$cat->jenis_name}}</option>
                    @endforeach
                </select>
                @error('jenis') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Pendidikan</label>
                <select name="pendidikan" id="" class="form-select" required>
                    <option value="notSelected">Select a pendidikan</option>
                    @foreach ($pendidikans as $cat)
                        <option {{$article->pendidikan_id == $cat->pendidikan_id ? 'selected' : ''}} value="{{$cat->pendidikan_id}}">{{$cat->pendidikan_name}}</option>
                    @endforeach
                </select>
                @error('pendidikan') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Tingkat</label>
                <select name="tingkat" id="" class="form-select" required>
                    <option value="notSelected">Select a tingkat</option>
                    @foreach ($tingkats as $cat)
                        <option {{$article->tingkat_id == $cat->tingkat_id ? 'selected' : ''}} value="{{$cat->tingkat_id}}">{{$cat->tingkat_name}}</option>
                    @endforeach
                </select>
                @error('tingkat') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Picture</label>
                <div class="row align-items-center">
                    <div class="col-sm-3">
                        <img src="{{asset($article->article_image)}}" class="w-100" alt="" srcset="">
                        <input type="hidden" name="oldimage" value="{{$article->article_image}}">
                    </div>
                    <div class="col-sm-9">
                        <input type="file" name="image" accept="image/*" class="form-control" >
                    </div>
                </div>
                @error('image') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <div id="editor" style="height: 14em">{!!$article->article_content!!}</div>
                <input type="hidden" name="content" id="content">
                @error('content') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="created_at" class="form-label">Created At</label>
                <input type="datetime-local" name="created_at" class="form-control" 
                       value="{{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d\TH:i') }}" required>
                @error('created_at') <div class="text-small text-danger">{{$message}}</div> @enderror
            </div>            
            <div class="mb-3 form-check">
                <input type="checkbox" {{$article->article_status == 1 ? 'checked' : ''}} name="status" id="" class="form-check-input">
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