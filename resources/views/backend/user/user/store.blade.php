<?php
$user_catalogue = ['[Chọn nhóm thành viên]', 'Quản trị viên', 'Cộng tác viên'];
$title = $config['method'] == 'create' ? $config['seo']['create']['title'] : $config['seo']['edit']['title'];
$url = $config['method'] == 'create' ? route('user.store') : route('user.update', $user->id);
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
                    <div class="panel-description">Nhập thông tin chung của người sử dụng</div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb-15">
                            {{-- Email --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Email
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="email" name="email"
                                        value="{{ old('email', isset($user) ? $user->email : '') }}"
                                        class="form-control" placeholder="">
                                    @if ($errors->has('email'))
                                        <span class="error-message">* {{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Name --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Họ tên
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name"
                                        value="{{ old('name', isset($user) ? $user->name : '') }}" class="form-control"
                                        placeholder="">
                                    @if ($errors->has('name'))
                                        <span class="error-message">* {{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-15">
                            {{-- Nhóm thành viên --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label ">
                                        Nhóm thành viên
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <select name="user_catalogue_id" class="form-control setupSelect2">
                                        @foreach ($user_catalogue as $key => $val)
                                            <option value="{{ $key }}"
                                                @if (old('user_catalogue_id', isset($user) ? $user->user_catalogue_id : 0) == $key) selected @endif>{{ $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_catalogue_id'))
                                        <span class="error-message">* {{ $errors->first('user_catalogue_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Birthday --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label ">
                                        Ngày sinh
                                    </label>
                                    <input type="date" name="birthday"
                                        value="{{ old('birthday', isset($user) ? date('Y-m-d', strtotime($user->birthday)) : '') }}"
                                        class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        @if ($config['method'] == 'create')
                            <div class="row mb-15">
                                {{-- Password --}}
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label">
                                            Mật khẩu
                                            <span class="text-danger">(*)</span>
                                        </label>
                                        <input type="password" name="password" value="" class="form-control"
                                            placeholder="">
                                        @if ($errors->has('password'))
                                            <span class="error-message">* {{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Re_Password --}}
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label">
                                            Nhập lại mật khẩu
                                            <span class="text-danger">(*)</span>
                                        </label>
                                        <input type="password" name="re_password" value="" class="form-control"
                                            placeholder="">
                                        @if ($errors->has('re_password'))
                                            <span class="error-message">* {{ $errors->first('re_password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-15">
                            {{-- Image --}}
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Ảnh đại diện
                                    </label>
                                    <input type="text" name="image"
                                        value="{{ old('image', isset($user) ? $user->image : '') }}"
                                        class="form-control upload-image" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        {{-- Thông tin liên hệ --}}
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin liên hệ</div>
                    <div class="panel-description">Nhập thông tin liên hệ của người sử dụng</div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb-15">
                            {{-- Province --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Thành Phố
                                    </label>
                                    <select name="province_id" class="form-control setupSelect2 provinces location"
                                        data-target='districts'>
                                        <option value="0" selected>[Chọn Thành Phố]</option>
                                        @if (isset($provinces) && is_object($provinces))
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->code }}"
                                                    @if (old('province_id') == $province->code) selected @endif>
                                                    {{ $province->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            {{-- Dístrict --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Quận/Huyện
                                    </label>
                                    <select name="district_id" class="form-control districts setupSelect2 location"
                                        data-target='wards'>
                                        <option value="0">[Chọn Quận/Huyện]</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-15">
                            {{-- Ward --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label ">
                                        Phường/Xã
                                    </label>
                                    <select name="ward_id" class="form-control setupSelect2 wards">
                                        <option value="0">[Chọn Phường/Xã]</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label ">
                                        Địa chỉ
                                    </label>
                                    <input type="text" name="address"
                                        value="{{ old('address', isset($user) ? $user->address : '') }}"
                                        class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-15">
                            {{-- Phone --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Số điện thoại
                                    </label>
                                    <input type="text" name="phone"
                                        value="{{ old('phone', isset($user) ? $user->phone : '') }}"
                                        class="form-control" placeholder="">
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Ghi chú
                                    </label>
                                    <input type="text" name="description"
                                        value="{{ old('description', isset($user) ? $user->description : '') }}"
                                        class="form-control" placeholder="">
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

{{-- Lấy ra giá trị để xử lý trong location.js --}}
<script>
    const province_id = '{{ old('province_id', isset($user) ? $user->province_id : 0) }}';
    const district_id = '{{ old('district_id', isset($user) ? $user->district_id : 0) }}';
    const ward_id = '{{ old('ward_id', isset($user) ? $user->ward_id : 0) }}';
</script>
