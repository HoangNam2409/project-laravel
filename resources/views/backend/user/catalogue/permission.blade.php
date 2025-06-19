{{-- Breadcumv --}}
@include('backend.dashboard.components.breadcumb', ['title' => $config['seo']['index']['title']])

<form action="{{ route('user.catalogue.update.permission') }}" method="POST" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        {{-- Thông tin cơ bản --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Cấp quyền</h5>
                    </div>
                </div>

                <div class="ibox-content">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th></th>
                            @foreach ($userCatalogues as $userCatalogue)
                                <th class="text-center">{{ $userCatalogue->name }}</th>
                            @endforeach
                        </tr>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>
                                    <div class="uk-flex uk-flex-space-between">
                                        <span>{{ $permission->name }}</span>
                                        <span style="color: blue">{{ $permission->canonical }}</span>
                                    </div>
                                </td>
                                @foreach ($userCatalogues as $userCatalogue)
                                    <td>
                                        <input
                                            {{ collect($userCatalogue->permissions)->contains('id', $permission->id) ? 'checked' : '' }}
                                            type="checkbox" name="permissions[{{ $userCatalogue->id }}][]"
                                            value="{{ $permission->id }}" class="form-control">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
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
