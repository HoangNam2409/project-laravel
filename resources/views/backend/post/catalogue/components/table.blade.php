<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">{{ __('messages.groupName') }}</th>
            <th class="text-center">{{ __('messages.status') }}</th>
            <th class="text-center">{{ __('messages.operation') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($post_catalogues) && is_object($post_catalogues))
            @foreach ($post_catalogues as $post_catalogue)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $post_catalogue->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        {{ str_repeat('|-----', $post_catalogue->level > 0 ? $post_catalogue->level - 1 : 0) . $post_catalogue->name }}
                    </td>
                    <td class="text-center js-switch-{{ $post_catalogue->id }}">
                        <input type="checkbox" class="js-switch status" value="{{ $post_catalogue->publish }}"
                            data-modelId="{{ $post_catalogue->id }}" data-model="{{ $config['model'] }}"
                            data-field="publish" @if ($post_catalogue->publish == 1) checked @endif />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('post.catalogue.edit', $post_catalogue->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('post.catalogue.delete', $post_catalogue->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
