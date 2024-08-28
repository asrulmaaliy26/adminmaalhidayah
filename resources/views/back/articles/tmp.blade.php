<div class="mb-3">
    <label class="form-label">Upload Picture</label>
    <div class="row align-items-center">
        <div class="col-sm-3">
            <img src="{{ asset($article->article_image) }}" class="w-100" alt="Current Image">
            <input type="hidden" name="oldimage" value="{{ $article->article_image }}">
        </div>
        <div class="col-sm-9">
            <input type="file" name="image_upload" accept="image/*" class="form-control">
        </div>
    </div>
    @error('image_upload') <div class="text-small text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Or Enter Image Link</label>
    <input type="url" name="image_link" placeholder="{{ asset($article->article_image) }}" class="form-control">
    @error('image_link') <div class="text-small text-danger">{{ $message }}</div> @enderror
</div>