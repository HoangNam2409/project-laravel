{{-- Chọn danh mục cha --}}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.parent') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb-15">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="text-danger notice">* {{ __('messages.parent_notice') }}</span>
                    <select name="parent_id" class="form-control setupSelect2">
                        @foreach ($dropdown as $key => $val)
                            <option @if ($key == old('parent_id', $post_catalogue->parent_id ?? '0')) selected @endif value="{{ $key }}">
                                {{ $val }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('parent_id'))
                        <span class="error-message">* {{ $errors->first('parent_id') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Image --}}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.avatar') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb-15">
            <div class="col-lg-12">
                <div class="form-row row-image">
                    <img class="img-post-catalogue image-target"
                        src="{{ old('image', $post_catalogue->image ?? 'backend/img/no-image.jpg') }}" alt="">
                    <input type="hidden" name="image" value="{{ old('image', $post_catalogue->image ?? '') }}">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cấu hình nâng cao --}}
<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.advanced') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb-15">
            <div class="col-lg-12">
                <div class="mb-20">
                    <select name="publish" class="form-control setupSelect2">
                        @foreach (__('messages.publish') as $key => $val)
                            <option @if ($key == old('publish', $post_catalogue->publish ?? '0')) selected @endif value="{{ $key }}">
                                {{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <select name="follow" class="form-control setupSelect2">
                    @foreach (__('messages.follow') as $key => $val)
                        <option @if ($key == old('follow', $post_catalogue->follow ?? '0')) selected @endif value="{{ $key }}">
                            {{ $val }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
