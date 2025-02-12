<div class="page-title">
    <div class="row" style="margin-top: -40px">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3 class="text-capitalize fs-2">{{ request()->segment(2) ?? request()->segment(1)  }}</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    @foreach (request()->segments() as $index => $item)
                        @if ($item != 'backend')
                            <li class="breadcrumb-item text-capitalize">{!! $loop->last ? '' : '<a href="#">' !!} {{ $item }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
</div>
