<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">{{ __('messages.permission_name') }}</th>
            <th class="text-center">{{ __('messages.canonical') }}</th>
            <th class="text-center">{{ __('messages.operation') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($permissions) && is_object($permissions))
            @foreach ($permissions as $permission)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $permission->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->canonical }}</td>
                    <td class="text-center">
                        <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('permission.delete', $permission->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
