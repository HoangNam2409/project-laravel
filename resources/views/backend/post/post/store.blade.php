<?php
$title = $config['method'] == 'create' ? $config['seo']['create']['title'] : $config['seo']['edit']['title'];
$url = $config['method'] == 'create' ? route('post.store') : route('post.update', $post->id);
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
                        <h5>Thông tin chung</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.post.post.components.general')
                    </div>
                </div>

                {{-- Album --}}
                @include('backend.post.post.components.album')

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Cấu hình SEO</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.post.post.components.seo')
                    </div>
                </div>
            </div>

            {{-- Aside --}}
            <div class="col-lg-3">
                @include('backend.post.post.components.aside')
            </div>
        </div>

        {{-- Submit --}}
        <div class="text-right mb-15">
            <button type="submit" name="send" value="send" class="btn btn-primary">Lưu
                lại</button>
        </div>
    </div>
</form>
