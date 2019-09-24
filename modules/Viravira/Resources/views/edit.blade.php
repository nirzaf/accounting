@extends('layouts.admin')

@section('title', trans('viravira::general.title'))

@section('content')
    <div class="row">
        {!! Form::open(['url' => 'viravira/settings', 'files' => true, 'role' => 'form', 'class' => 'form-loading-button']) !!}
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    {{ Form::textGroup('token', trans('viravira::general.form.token'), 'key', ['required' => 'required'], old('token', setting('viravira.token'))) }}

                    {{ Form::selectGroup('account_id', trans_choice('general.accounts', 1), 'university', $accounts, old('account_id', setting('viravira.account_id'))) }}

                    @stack('product_category_id_input_start')
                    <div class="form-group col-md-6 required {{ $errors->has('product_category_id') ? 'has-error' : ''}}">
                        {!! Form::label('product_category_id', trans('viravira::general.form.product_category'), ['class' => 'control-label']) !!}
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-folder-open-o"></i></div>
                            {!! Form::select('product_category_id', $product_categories, old('product_category_id', setting('viravira.product_category_id')), array_merge(['class' => 'form-control', 'placeholder' => trans('general.form.select.field', ['field' => trans('viravira::general.form.product_category')])])) !!}
                            <div class="input-group-btn">
                                <button type="button" id="button-product-category" class="btn btn-default btn-icon"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        {!! $errors->first('product_category_id', '<p class="help-block">:message</p>') !!}
                    </div>
                    @stack('product_category_id_input_end')

                    @stack('invoice_category_id_input_start')
                    <div class="form-group col-md-6 required {{ $errors->has('invoice_category_id') ? 'has-error' : ''}}">
                        {!! Form::label('invoice_category_id', trans('viravira::general.form.invoice_category'), ['class' => 'control-label']) !!}
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-folder-open-o"></i></div>
                            {!! Form::select('invoice_category_id', $invoice_categories, old('invoice_category_id', setting('viravira.invoice_category_id')), array_merge(['class' => 'form-control', 'placeholder' => trans('general.form.select.field', ['field' => trans('viravira::general.form.invoice_category')])])) !!}
                            <div class="input-group-btn">
                                <button type="button" id="button-invoice-category" class="btn btn-default btn-icon"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        {!! $errors->first('invoice_category_id', '<p class="help-block">:message</p>') !!}
                    </div>
                    @stack('invoice_category_id_input_end')

                    {{ Form::radioGroup('sync', trans('general.enabled')) }}
                </div>

                <div class="box-footer">
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            {!! Form::button('<span class="fa fa-save"></span> &nbsp;' . trans('general.save'), ['type' => 'submit', 'class' => 'btn btn-success  button-submit', 'data-loading-text' => trans('general.loading')]) !!}

                            <div id="button-sync-action" class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                    <span class="fa fa-exchange"></span> &nbsp; {{ trans('viravira::general.form.sync.title') }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#" id="button-all-sync">{{ trans('viravira::general.form.sync.all') }}</a></li>
                                    <li><a href="#" id="button-customer-sync">{{ trans('viravira::general.form.sync.customer') }}</a></li>
                                    <li><a href="#" id="button-product-sync">{{ trans('viravira::general.form.sync.product') }}</a></li>
                                    <li><a href="#" id="button-order-sync">{{ trans('viravira::general.form.sync.order') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('js')
    <script src="{{ asset('vendor/almasaeed2010/adminlte/plugins/colorpicker/bootstrap-colorpicker.js') }}"></script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/almasaeed2010/adminlte/plugins/colorpicker/bootstrap-colorpicker.css') }}">
@endpush

@push('stylesheet')
    <style>
        .loading-spin {
            margin-left: 10px;
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        var total = 0;
        var step = new Array();

        $(document).ready(function(){
            $('#token').focus();

            @if (setting('viravira.sync'))
            $('#sync_1').trigger('click');
            @else
            $('.btn.btn-default.dropdown-toggle').attr('disabled', 'true');
            @endif

            $("#account_id").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.accounts', 1)]) }}"
            });

            $("#product_category_id").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans('viravira::general.form.product_category')]) }}"
            });

            $("#invoice_category_id").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans('viravira::general.form.invoice_category')]) }}"
            });
        });

        $(document).on('click', '#button-product-category', function (e) {
            $('#modal-create-category').remove();

            $.ajax({
                url: '{{ url("modals/categories/create") }}',
                type: 'GET',
                dataType: 'JSON',
                data: {type: 'item'},
                success: function(json) {
                    if (json['success']) {
                        $('body').append(json['html']);
                    }
                }
            });
        });

        $(document).on('click', '#button-invoice-category', function (e) {
            $('#modal-create-category').remove();

            $.ajax({
                url: '{{ url("modals/categories/create") }}',
                type: 'GET',
                dataType: 'JSON',
                data: {type: 'income'},
                success: function(json) {
                    if (json['success']) {
                        $('body').append(json['html']);
                    }
                }
            });
        });

        $(document).on('click', '#button-all-sync', function (e) {
            $('#row-sync').remove();
            $('.text-danger').remove();
            $('#button-sync-action').after('<div class="loading-spin"><i class="fa fa-spinner fa-3x fa-spin fa-fw" aria-hidden="true"></i></div>');

            $.ajax({
                url: '{{ url("viravira/sync/count") }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(json) {
                    if (json['errors']) {
                        $('.fa.fa-spinner.fa-3x.fa-spin').remove();
                        $('#button-sync-action').after('<div class="text-danger">' + json['errors'] + '</div>');
                    }

                    if (json['success']) {
                        $('.content.content-center').append(json['html']);
                        $('.fa.fa-spinner.fa-3x.fa-spin').remove();

                        $('#progress-bar').css('width', (100 - (step.length / total) * 100) + '%');

                        $.ajax({
                            url: '{{ url("viravira/sync/sync") }}',
                            type: 'GET',
                            dataType: 'JSON',
                            success: function(json) {
                                if (json['errors']) {
                                    $('#progress-bar').addClass('progress-bar-danger');
                                    $('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
                                }

                                if (json['step']) {
                                    step = json['step'];
                                    total = step.length;

                                    next();
                                }
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click', '#button-customer-sync', function (e) {
            $('#row-sync').remove();
            $('.text-danger').remove();
            $('#button-sync-action').after('<div class="loading-spin"><i class="fa fa-spinner fa-3x fa-spin fa-fw" aria-hidden="true"></i></div>');

            $.ajax({
                url: '{{ url("viravira/customers/count") }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(json) {
                    if (json['errors']) {
                        $('.fa.fa-spinner.fa-3x.fa-spin').remove();
                        $('#button-sync-action').after('<div class="text-danger">' + json['errors'] + '</div>');
                    }

                    if (json['success']) {
                        $('.content.content-center').append(json['html']);
                        $('.fa.fa-spinner.fa-3x.fa-spin').remove();

                        $('#progress-bar').css('width', (100 - (step.length / total) * 100) + '%');

                        $.ajax({
                            url: '{{ url("viravira/customers/sync") }}',
                            type: 'GET',
                            dataType: 'JSON',
                            success: function(json) {
                                if (json['errors']) {
                                    $('#progress-bar').addClass('progress-bar-danger');
                                    $('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
                                }

                                if (json['step']) {
                                    step = json['step'];
                                    total = step.length;

                                    next();
                                }
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click', '#button-product-sync', function (e) {
            $('#row-sync').remove();
            $('.text-danger').remove();
            $('#button-sync-action').after('<div class="loading-spin"><i class="fa fa-spinner fa-3x fa-spin fa-fw" aria-hidden="true"></i></div>');

            $.ajax({
                url: '{{ url("viravira/products/count") }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(json) {
                    if (json['errors']) {
                        $('.fa.fa-spinner.fa-3x.fa-spin').remove();
                        $('#button-sync-action').after('<div class="text-danger">' + json['errors'] + '</div>');
                    }

                    if (json['success']) {
                        $('.content.content-center').append(json['html']);
                        $('.fa.fa-spinner.fa-3x.fa-spin').remove();

                        $('#progress-bar').css('width', (100 - (step.length / total) * 100) + '%');

                        $.ajax({
                            url: '{{ url("viravira/products/sync") }}',
                            type: 'GET',
                            dataType: 'JSON',
                            success: function(json) {
                                if (json['errors']) {
                                    $('#progress-bar').addClass('progress-bar-danger');
                                    $('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
                                }

                                if (json['step']) {
                                    step = json['step'];
                                    total = step.length;

                                    next();
                                }
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click', '#button-order-sync', function (e) {
            $('#row-sync').remove();
            $('.text-danger').remove();
            $('#button-sync-action').after('<div class="loading-spin"><i class="fa fa-spinner fa-3x fa-spin fa-fw" aria-hidden="true"></i></div>');

            $.ajax({
                url: '{{ url("viravira/orders/count") }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(json) {
                    if (json['errors']) {
                        $('.fa.fa-spinner.fa-3x.fa-spin').remove();
                        $('#button-sync-action').after('<div class="text-danger">' + json['errors'] + '</div>');
                    }

                    if (json['success']) {
                        $('.content.content-center').append(json['html']);
                        $('.fa.fa-spinner.fa-3x.fa-spin').remove();

                        $('#progress-bar').css('width', (100 - (step.length / total) * 100) + '%');

                        $.ajax({
                            url: '{{ url("viravira/orders/sync") }}',
                            type: 'GET',
                            dataType: 'JSON',
                            success: function(json) {
                                if (json['errors']) {
                                    $('#progress-bar').addClass('progress-bar-danger');
                                    $('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
                                }

                                if (json['step']) {
                                    step = json['step'];
                                    total = step.length;

                                    next();
                                }
                            }
                        });
                    }
                }
            });
        });

        function next() {
            data = step.shift();

            if (data) {
                $('#progress-bar').css('width', (100 - (step.length / total) * 100) + '%');
                $('#progress-text').html('<span class="text-info">' + data['text'] + '</span>');

                setTimeout(function() {
                    $.ajax({
                        url: data.url,
                        type: 'post',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        success: function(json) {
                            if (json['errors']) {
                                $('#progress-bar').addClass('progress-bar-danger');
                                $('#progress-text').html('<div class="text-danger">' + json['errors'] + '</div>');
                            }

                            if (json['success']) {
                                $('#progress-bar').removeClass('progress-bar-danger');
                                $('#progress-bar').addClass('progress-bar-success');
                            }

                            if (!json['errors'] && (!json['finished'] || (json['finished'] && ((100 - (step.length / total) * 100) != 100)))) {
                                next();
                            }

                            if (json['finished']) {
                                $('#progress-text').html('<span class="text-info">' + json['finished'] + '</span>');
                                //window.location = json['installed'];
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 800);
            }
        }
    </script>
@endpush
