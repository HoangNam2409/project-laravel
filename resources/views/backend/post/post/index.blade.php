{{-- Breadcumv --}}
@include('backend.dashboard.components.breadcumb', ['title' => $config['seo']['index']['title']])

{{-- Table --}}
<div class="row mt-20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            {{-- Title --}}
            <div class="ibox-title">
                <h5 class="table-heading">{{ $config['seo']['index']['tableHeading'] }}</h5>
                {{-- ToolBox --}}
                @include('backend.post.post.components.toolbox')
            </div>

            {{-- Content --}}
            <div class="ibox-content">
                {{-- Filter --}}
                @include('backend.post.post.components.filter')
                {{-- Table --}}
                @include('backend.post.post.components.table')
                {{-- Perpage --}}
                @if (isset($languages) && is_object($languages))
                    {{ $languages->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
</div>
