<div class="ibox">
    <div class="ibox-title">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <h5>{{ __('messages.album') }}</h5>
            <div class="upload-album">
                <a href="" class="upload-picture">{{ __('messages.chooseImage') }}</a>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        @php
            $gallery = isset($album) && count($album) ? $post_catalogue->album : old('album');
        @endphp
        <div class="row">
            <div class="col-lg-12">
                <div class="click-to-upload {{ !isset($gallery) || count($gallery) == 0 ? '' : 'hidden' }}">
                    <div class="icon">
                        <a href="" class="upload-picture">
                            <img class="picture-album" src="backend/img/picture.jpg" alt="">
                        </a>
                    </div>
                    <div class="small-text">{{ __('messages.albumDescription') }}</div>
                </div>

                <div class="upload-list {{ isset($gallery) && count($gallery) ? '' : 'hidden' }}">
                    <div class="row">
                        <ul id="sortable" class="clearfix data-album sortui ui-sortable">
                            @if (isset($gallery) && count($gallery))
                                @foreach ($gallery as $key => $val)
                                    <li class="ui-state-default">
                                        <div class="thumb">
                                            <span class="span image img-scaledown">
                                                <img src="{{ $val }}" alt="{{ $val }}">
                                                <input type="hidden" name="album[]" value="{{ $val }}">
                                            </span>
                                            <button class="delete-image">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
