{{-- Name --}}
<div class="row mb-15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label">
                {{ __('messages.title') }}
                <span class="text-danger">(*)</span>
            </label>
            <input type="text" name="name" value="{{ old('name', $post_catalogue->name ?? '') }}" class="form-control"
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
            <label for="" class="control-label">{{ __('messages.description') }}</label>
            <textarea name="description" id="description" class="ck-editor form-control" data-height="150">{{ old('description', $post_catalogue->description ?? '') }}</textarea>
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
                <label for="" class="control-label">{{ __('messages.content') }}</label>
                {{-- <a href="" class="multipleUploadImageCKeditor" data-target="ckContent">Upload nhiều ảnh</a> --}}
            </div>
            <textarea name="content" id="content" class="ck-editor form-control" data-height="500">{{ old('content', $post_catalogue->content ?? '') }}</textarea>
            @if ($errors->has('content'))
                <span class="error-message">* {{ $errors->first('content') }}</span>
            @endif
        </div>
    </div>
</div>
