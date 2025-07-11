<form action="{{ route('permission.index') }}">
    <div class="filter-wrapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            {{-- Select ban ghi --}}
            <div class="perpage">
                <select name="perpage" class="form-control input-sm perpage filter mr-10">
                    @for ($i = 20; $i <= 200; $i += 20)
                        <option @if (request('perpage') == $i) selected @endif value="{{ $i }}">
                            {{ $i }}
                            {{ __('messages.perpage') }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Action --}}
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    {{-- Select publish --}}
                    @php
                        $publish = request('publish') ?? -1;
                    @endphp
                    <select name="publish" class="form-control mr-10">
                        @foreach (__('messages.publish') as $key => $val)
                            <option {{ $publish == $key ? 'selected' : '' }} value="{{ $key }}">
                                {{ $val }}</option>
                        @endforeach
                    </select>

                    {{-- Search --}}
                    <div class="uk-search uk-flex uk-flex-middle">
                        <div class="input-group">
                            <input type="text" name="keyword" value="{{ request('keyword') }}"
                                placeholder="{{ __('messages.placeHolder') }}" class="form-control">

                            {{-- Button --}}
                            <span class="input-group-btn">
                                <button type="submit" name="search" value="search"
                                    class="btn btn-primary mb0 btn-sm btn mr-10">
                                    {{ __('messages.search') }}
                                </button>
                            </span>
                        </div>
                        <a href="{{ route('permission.create') }}" class="btn btn-danger">
                            <i class="fa fa-plus mr-5"></i>
                            {{ __('messages.permission.create.title') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
