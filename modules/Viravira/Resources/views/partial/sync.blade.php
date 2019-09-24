@if (empty($all))
    <div id="row-sync" class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    <h3>{{ trans('viravira::general.total', ['type' => $type, 'count' => $total]) }}</h3>

                    <div class="progress">
                        <div id="progress-bar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                          <span class="sr-only"></span>
                        </div>
                    </div>

                    <div id="progress-text"></div>
                </div>
            </div>
        </div>
    </div>
@else
    <div id="row-sync" class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    <h3>{{ trans('viravira::general.total_all', ['customers' => $customers, 'products' => $products,'orders' => $orders,]) }}</h3>

                    <div class="progress">
                        <div id="progress-bar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            <span class="sr-only"></span>
                        </div>
                    </div>

                    <div id="progress-text"></div>
                </div>
            </div>
        </div>
    </div>
@endif
