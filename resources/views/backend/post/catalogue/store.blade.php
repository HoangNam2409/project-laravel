<?php
$title = $config['method'] == 'create' ? __('messages.postCatalogue.create.title') : __('messages.postCatalogue.edit.title');
$url = $config['method'] == 'create' ? route('post.catalogue.store') : route('post.catalogue.update', $post_catalogue->id);
?>

{{-- Breadcumv --}}
@include('backend.dashboard.components.breadcumb', ['title' => $title])

<form action="{{ $url }}" method="POST" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        {{-- Thông tin cơ bản --}}
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.infoGeneral') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.post.catalogue.components.general')
                    </div>
                </div>

                {{-- Album --}}
                @include('backend.post.catalogue.components.album')

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.configSEO') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.post.catalogue.components.seo')
                    </div>
                </div>
            </div>

            {{-- Aside --}}
            <div class="col-lg-3">
                @include('backend.post.catalogue.components.aside')
            </div>
        </div>

        {{-- Submit --}}
        <div class="text-right mb-15">
            <button type="submit" name="send" value="send"
                class="btn btn-primary">{{ __('messages.save') }}</button>
        </div>
    </div>
</form>
