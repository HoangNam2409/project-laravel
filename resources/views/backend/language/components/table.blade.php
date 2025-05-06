<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Ảnh</th>
            <th class="text-center">Tên ngôn ngữ</th>
            <th class="text-center">Canonical</th>
            <th class="text-center">Tình trạng</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($languages) && is_object($languages))
            @foreach ($languages as $language)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" value="{{ $language->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td class="text-center">
                        <img class="image-language" src="{{ $language->image }}" alt="">
                    </td>
                    <td class="text-center">{{ $language->name }}</td>
                    <td class="text-center">{{ $language->canonical }}</td>
                    <td class="text-center js-switch-{{ $language->id }}">
                        <input type="checkbox" class="js-switch status" value="{{ $language->publish }}"
                            data-modelId="{{ $language->id }}" data-model="{{ $config['model'] }}" data-field="publish"
                            @if ($language->publish == 1) checked @endif />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('language.edit', $language->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('language.delete', $language->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
