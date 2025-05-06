{{-- Breadcumv --}}
@include('backend.dashboard.components.breadcumb', ['title' => $config['seo']['delete']['title']])

<form action="{{ route('user.destroy', $user->id) }}" method="POST" class="box">
    @csrf
    @method('delete')
    <div class="wrapper wrapper-content animated fadeInRight">
        {{-- Thông tin cơ bản --}}
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin</div>
                    <div class="panel-description">
                        Bạn có muốn chắc chắn xoá email:
                        <span class="text-delete text-danger">{{ $user->email }}</span>
                    </div>
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
                                    </label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="form-control" readonly>
                                </div>
                            </div>

                            {{-- Name --}}
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Họ tên
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Button Delete --}}
        <div class="text-right mb-15">
            <a href="{{ route('user.index') }}" class="btn btn-success">Huỷ</a>
            <button type="submit" name="send" value="send" class="btn btn-danger">Xoá dữ liệu</button>
        </div>
    </div>
</form>
