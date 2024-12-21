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
    
    // Initialize Quill Editor
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    [{ 'header': [1, 2, false] }],
                    [{ 'font': [] }],
                    [{ 'size': ['small', 'medium', 'large', 'huge'] }],
                    [{ 'align': [] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['link', 'image', 'blockquote', 'code-block'],
                    [{ 'direction': 'rtl' }],
                    ['undo', 'redo'] // Corrected toolbar structure
                ],
                handlers: {
                    image: imageHandler
                }
            }
        }
    });

    // Custom Image Handler
    function imageHandler() {
        const url = prompt('Enter the image URL');
        if (url) {
            const range = quill.getSelection();
            if (range) {
                // Insert image at the current cursor position
                quill.insertEmbed(range.index, 'image', url);

                // Delay to ensure the image is rendered before applying styles
                setTimeout(() => {
                    const image = document.querySelector(`img[src="${url}"]`);
                    if (image) {
                        // Add custom class for styling
                        image.classList.add('custom-image');
                    }
                }, 100);
            } else {
                alert('Please place the cursor where you want to insert the image.');
            }
        }
    }

    // Form submit: Set Quill content to a hidden input field
    var form = document.querySelector('form');
    if (form) {
        form.onsubmit = function () {
            var content = document.querySelector('input#content');
            if (content) {
                content.value = quill.root.innerHTML; // Extract HTML from Quill
            } else {
                console.error('Input field with ID "content" not found.');
            }
        };
    } else {
        console.error('Form element not found.');
    }

    // Add CSS for consistent image styling
    const style = document.createElement('style');
    style.innerHTML = `
        .custom-image {
            height: 700px;
            width: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    `;
    document.head.appendChild(style);


    form.onsubmit = function() {
        var content = document.querySelector('input#content');
        content.value = quill.root.innerHTML;
    };

    </script>

@endsection