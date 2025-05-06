<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Họ tên</th>
            <th class="text-center">Số thành viên</th>
            <th class="text-center">Ghi chú</th>
            <th class="text-center">Tình trạng</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($user_catalogues) && is_object($user_catalogues))
            @foreach ($user_catalogues as $user_catalogue)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $user_catalogue->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>{{ $user_catalogue->name }}</td>
                    <td class="text-center">{{ $user_catalogue->users_count }} thành viên</td>
                    <td>{{ $user_catalogue->description }}</td>
                    <td class="text-center js-switch-{{ $user_catalogue->id }}">
                        <input type="checkbox" class="js-switch status" value="{{ $user_catalogue->publish }}"
                            data-modelId="{{ $user_catalogue->id }}" data-model="{{ $config['model'] }}"
                            data-field="publish" @if ($user_catalogue->publish == 1) checked @endif />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('user.catalogue.edit', $user_catalogue->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('user.catalogue.delete', $user_catalogue->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
