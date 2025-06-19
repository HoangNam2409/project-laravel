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
                {{-- @include('backend.permission.components.toolbox') --}}
            </div>

            {{-- Content --}}
            <div class="ibox-content">
                {{-- Filter --}}
                @include('backend.permission.components.filter')
                {{-- Table --}}
                @include('backend.permission.components.table')
                {{-- Perpage --}}
                @if (isset($permissions) && is_object($permissions))
                    {{ $permissions->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
</div>
