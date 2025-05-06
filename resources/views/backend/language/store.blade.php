<?php
$title = $config['method'] == 'create' ? $config['seo']['create']['title'] : $config['seo']['edit']['title'];
$url = $config['method'] == 'create' ? route('language.store') : route('language.update', $language->id);
?>

{{-- Breadcumv --}}
@include('backend.dashboard.components.breadcumb', ['title' => $title])

<form action="{{ $url }}" method="POST" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        {{-- Thông tin cơ bản --}}
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">Nhập các thông tin chung của ngôn ngữ</div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb-15">
                            {{-- Name --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Tên ngôn ngữ
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name"
                                        value="{{ old('name', isset($language) ? $language->name : '') }}"
                                        class="form-control" placeholder="">
                                    @if ($errors->has('name'))
                                        <span class="error-message">* {{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Canonical --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Canonical
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="canonical"
                                        value="{{ old('canonical', isset($language) ? $language->canonical : '') }}"
                                        class="form-control" placeholder="">
                                    @if ($errors->has('canonical'))
                                        <span class="error-message">* {{ $errors->first('canonical') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-15">
                            {{-- Image --}}
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Ảnh đại diện
                                    </label>
                                    <input type="text" name="image"
                                        value="{{ old('image', isset($language) ? $language->image : '') }}"
                                        class="form-control upload-image" placeholder="" data-type='Images'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="text-right mb-15">
            <button type="submit" name="send" value="send" class="btn btn-primary">Lưu
                lại</button>
        </div>
    </div>
</form>
