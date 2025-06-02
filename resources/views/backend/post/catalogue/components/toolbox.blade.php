<div class="ibox-tools">
    <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
    </a>
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-wrench"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li><a class="changeStatusAll" data-value="1" data-field="publish"
                data-model="{{ $config['model'] }}">{{ __('messages.pub') }}</a>
        </li>
        <li><a class="changeStatusAll" data-value="2" data-field="publish"
                data-model="{{ $config['model'] }}">{{ __('messages.unpub') }}</a>
        </li>
    </ul>
    <a class="close-link">
        <i class="fa fa-times"></i>
    </a>
</div>
