{{-- Name --}}
<div class="row mb-15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label">
                Tiêu đề bài viết
                <span class="text-danger">(*)</span>
            </label>
            <input type="text" name="name" value="{{ old('name', $post->name ?? '') }}" class="form-control"
                placeholder="">
            @if ($errors->has('name'))
                <span class="error-message">* {{ $errors->first('name') }}</span>
            @endif
        </div>
    </div>
</div>
{{-- Description --}}
<div class="row mb-30">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label">Mô tả ngắn</label>
            <textarea name="description" id="description" class="ck-editor form-control" data-height="150">{{ old('description', $post->description ?? '') }}</textarea>
            @if ($errors->has('description'))
                <span class="error-message">* {{ $errors->first('description') }}</span>
            @endif
        </div>
    </div>
</div>
{{-- Content --}}
<div class="row mb-15">
    <div class="col-lg-12">
        <div class="form-row">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <label for="" class="control-label">Nội dung</label>
                {{-- <a href="" class="multipleUploadImageCKeditor" data-target="ckContent">Upload nhiều ảnh</a> --}}
            </div>
            <textarea name="content" id="content" class="ck-editor form-control" data-height="500">{{ old('content', $post->content ?? '') }}</textarea>
            @if ($errors->has('content'))
                <span class="error-message">* {{ $errors->first('content') }}</span>
            @endif
        </div>
    </div>
</div>
