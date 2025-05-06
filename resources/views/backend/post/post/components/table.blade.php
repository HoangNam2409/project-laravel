<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center w-300">Tên bài viết</th>
            <th class="text-center w-80">Vị trí</th>
            <th class="text-center w-100">Tình trạng</th>
            <th class="text-center w-120">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($posts) && is_object($posts))
            @foreach ($posts as $post)
                <tr id="{{ $post->id }}">
                    <td class="text-center">
                        <input type="checkbox" value="{{ $post->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        <div class="uk-flex uk-flex-middle">
                            <div class="image mr-12">
                                <div class="image-post"><img class="image-cover" src="{{ $post->image }}"
                                        alt=""></div>
                            </div>
                            <div class="main-info">
                                <div class="name">
                                    <span class="main-title">{{ $post->name }}</span>
                                </div>
                                <div class="catalogue">
                                    <span class="text-danger">Nhóm hiển thị:</span>
                                    @foreach ($post->post_catalogues as $key => $val)
                                        @foreach ($val->post_catalogue_language as $item)
                                            <a href="{{ route('post.index', ['post_catalogue_id' => $val->id]) }}"
                                                title="">{{ $item->name }}</a>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="order" class="form-control sort-order text-center"
                            value="{{ $post->order }}" data-id="{{ $post->id }}"
                            data-model="{{ $config['model'] }}">
                    </td>
                    <td class="text-center js-switch-{{ $post->id }}">
                        <input type="checkbox" class="js-switch status" value="{{ $post->publish }}"
                            data-modelId="{{ $post->id }}" data-model="{{ $config['model'] }}"
                            data-field="publish" @if ($post->publish == 1) checked @endif />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
