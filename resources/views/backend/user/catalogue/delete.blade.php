{{-- Breadcumv --}}
@include('backend.dashboard.components.breadcumb', ['title' => $config['seo']['delete']['title']])

<form action="{{ route('user.catalogue.destroy', $user_catalogue->id) }}" method="POST" class="box">
    @csrf
    @method('delete')
    <div class="wrapper wrapper-content animated fadeInRight">
        {{-- Thông tin cơ bản --}}
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin</div>
                    <div class="panel-description">
                        Bạn có muốn chắc chắn xoá nhóm thành viên:
                        <span class="text-delete text-danger">{{ $user_catalogue->name }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb-15">
                            {{-- Name --}}
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label">
                                        Nhóm thành viên
                                    </label>
                                    <input type="text" name="name"
                                        value="{{ old('name', $user_catalogue->name) }}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Button Delete --}}
        <div class="text-right mb-15">
            <a href="{{ route('user.catalogue.index') }}" class="btn btn-success">Huỷ</a>
            <button type="submit" name="send" value="send" class="btn btn-danger">Xoá dữ liệu</button>
        </div>
    </div>
</form>
