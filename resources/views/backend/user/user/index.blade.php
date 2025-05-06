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
                @include('backend.user.user.components.toolbox')
            </div>

            {{-- Content --}}
            <div class="ibox-content">
                {{-- Filter --}}
                @include('backend.user.user.components.filter')
                {{-- Table --}}
                @include('backend.user.user.components.table')
                {{-- Perpage --}}
                @if (isset($users) && is_object($users))
                    {{ $users->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
</div>
