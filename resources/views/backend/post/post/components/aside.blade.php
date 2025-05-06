@php
    $catalogue = [];
    if (isset($post)) {
        foreach ($post->post_catalogues as $key => $val) {
            $catalogue[] = $val->id;
        }
    }
@endphp


{{-- Chọn danh mục cha --}}
<div class="ibox">
    <div class="ibox-title">
        <h5>Chọn danh mục cha</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb-15">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="text-danger notice">* Chọn root nếu không có danh mục cha</span>
                    <select name="post_catalogue_id" class="form-control setupSelect2">
                        @foreach ($dropdown as $key => $val)
                            <option @if ($key == old('post_catalogue_id', isset($post->post_catalogue_id) ? $post->post_catalogue_id : '')) selected @endif value="{{ $key }}">
                                {{ $val }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('post_catalogue_id'))
                        <span class="error-message">* {{ $errors->first('post_catalogue_id') }}</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Danh mục phụ --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">Chọn danh mục phụ</label>
                    <select multiple name="catalogue[]" class="form-control setupSelect2">
                        @foreach ($dropdown as $key => $val)
                            <option @if (is_array(old('catalogue', isset($catalogue) ? $catalogue : [])) &&
                                    in_array($key, old('catalogue', isset($catalogue) ? $catalogue : [])) &&
                                    $key !== $post->post_catalogue_id) selected @endif value="{{ $key }}">
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('catalogue'))
                        <span class="error-message">* {{ $errors->first('catalogue') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Image --}}
<div class="ibox">
    <div class="ibox-title">
        <h5>Chọn ảnh đại diện</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb-15">
            <div class="col-lg-12">
                <div class="form-row row-image">
                    <img class="img-post-catalogue image-target"
                        src="{{ old('image', $post->image ?? 'backend/img/no-image.jpg') }}" alt="">
                    <input type="hidden" name="image" value="{{ old('image', $post->image ?? '') }}">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cấu hình nâng cao --}}
<div class="ibox">
    <div class="ibox-title">
        <h5>Cấu hình nâng cao</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb-15">
            <div class="col-lg-12">
                <div class="mb-20">
                    <select name="publish" class="form-control setupSelect2">
                        @foreach (config('apps.general.publish') as $key => $val)
                            <option @if ($key == old('publish', $post_catalogue->publish ?? '0')) selected @endif value="{{ $key }}">
                                {{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <select name="follow" class="form-control setupSelect2">
                    @foreach (config('apps.general.follow') as $key => $val)
                        <option @if ($key == old('follow', $post_catalogue->follow ?? '0')) selected @endif value="{{ $key }}">
                            {{ $val }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
