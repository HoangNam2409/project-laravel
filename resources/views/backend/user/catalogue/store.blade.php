<?php
$title = $config['method'] == 'create' ? $config['seo']['create']['title'] : $config['seo']['edit']['title'];
$url = $config['method'] == 'create' ? route('user.catalogue.store') : route('user.catalogue.update', $user_catalogue->id);
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
                    <div class="panel-description">Cập nhật các thông tin chung của nhóm thành viên</div>
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
                                        Tên nhóm thành viên
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name"
                                        value="{{ old('name', isset($user_catalogue) ? $user_catalogue->name : '') }}"
                                        class="form-control" placeholder="">
                                    @if ($errors->has('name'))
                                        <span class="error-message">* {{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Ghi chú
                                    </label>
                                    <input type="text" name="description"
                                        value="{{ old('description', isset($user_catalogue) ? $user_catalogue->description : '') }}"
                                        class="form-control" placeholder="">
                                    @if ($errors->has('description'))
                                        <span class="error-message">* {{ $errors->first('description') }}</span>
                                    @endif
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
