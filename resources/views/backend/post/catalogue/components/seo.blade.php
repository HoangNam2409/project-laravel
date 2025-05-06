<div class="seo-container">
    <div class="meta-title">
        {{ old('meta_title', $post_catalogue->meta_title ?? 'Bạn chưa có tiêu đề SEO. Hãy nhập tiêu đề SEO.') }}</div>
    <div class="canonical">
        {{ old('canonical', isset($post_catalogue->canonical) ? $post_catalogue->canonical : '') ? config('app.url') . old('canonical', isset($post_catalogue->canonical) ? $post_catalogue->canonical : '') : config('app.url') }}
    </div>
    <div class="meta-description">
        {{ old('meta_description', $post_catalogue->meta_description ?? 'Bạn chưa có nội dung SEO. Hãy nhập nội dung SEO.') }}
    </div>
</div>

{{-- SEO --}}
<div class="seo-wrapper">
    {{-- Meta-title --}}
    <div class="row mb-15">
        <div class="col-lg-12">
            <div class="form-row">
                <label for="" class="control-label">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        Tiêu đề SEO
                        <span class="count">0 ký tự</span>
                    </div>
                </label>
                <input type="text" name="meta_title"
                    value="{{ old('meta_title', isset($post_catalogue) ? $post_catalogue->meta_title : '') }}"
                    class="form-control" placeholder="">
            </div>
        </div>
    </div>

    {{-- Meta-keyword --}}
    <div class="row mb-15">
        <div class="col-lg-12">
            <div class="form-row">
                <label for="" class="control-label">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        Từ khoá SEO
                        <span class="count">0 ký tự</span>
                    </div>
                </label>
                <input type="text" name="meta_keyword"
                    value="{{ old('meta_keyword', $post_catalogue->meta_keyword ?? '') }}" class="form-control"
                    placeholder="">
            </div>
        </div>
    </div>

    {{-- Canonical --}}
    <div class="row mb-15">
        <div class="col-lg-12">
            <div class="form-row">
                <label for="" class="control-label">
                    Đường dẫn
                </label>
                <div class="input-wrapper">
                    <input type="text" name="canonical"
                        value="{{ old('canonical', $post_catalogue->canonical ?? '') }}" class="form-control"
                        placeholder="">
                    <span class="base-url">{{ config('app.url') }}</span>
                </div>
                @if ($errors->has('canonical'))
                    <span class="error-message">* {{ $errors->first('canonical') }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Meta-description --}}
    <div class="row mb-15">
        <div class="col-lg-12">
            <div class="form-row">
                <label for="" class="control-label">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        Mô tả SEO
                        <span class="count">0 ký tự</span>
                    </div>
                </label>
                <textarea name="meta_description" class="form-control">{{ old('meta_description', $post_catalogue->meta_description ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>
