@extends('layouts.app')   
	@section('title')
        @lang('Edit a text')
	@stop

	@section('middle')
		@if ($errors->any())
			<script type="text/javascript">
				$(function() {
					$('.alert.collapse').collapse();
				});
			</script>

			<div class="alert alert-danger collapse">
				{!! implode('', $errors->all('<span>:message</span><br/>')) !!}
			</div>
		@endif

    	<div class="col">
    		<div class="card">
    			<h3 class="card-title text-center">@lang('Edit a text')</h3>
    			<div class="card-body">
    				<div class="col-sm-12">
    					{!! Form::model($customText, ['route'=>['admin.customText.update', $customText->id], 'method'=>'put','class'=>'form-horizontal panel d-flex flex-wrap justify-content-center']) !!}
						{{ csrf_field() }}
    					<div style="flex:0 0 90%" class="form-group me-2" {!! $errors->has('text') ? 'has-error' : '' !!}">
                            <h3>@lang('French')</h3>
    						{!! Form::textarea('text', null, ['class'=>'form-control', 'placeholder'=>__('Text')]) !!}
    						{!! $errors->first('text', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div style="flex:0 0 90%" class="form-group" {!! $errors->has('translation') ? 'has-error' : '' !!}">
                            <h3>@lang('English')</h3>
    						{!! Form::textarea('translation', null, ['class'=>'form-control', 'placeholder'=>__('Translation')]) !!}
    						{!! $errors->first('translation', '<small class="help-block">:message</small>') !!}
    					</div>
                        <div class="w-100 d-flex justify-content-center" style="flex:0 0 100%;">
                            {!! Form::submit(__('Edit'), ['class'=>'btn pull-right me-2']) !!}
                            <a href="{{ url()->previous() }}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-circle-arrow-left"></span>@lang('Back')
                            </a>
                        </div>
    					{!! Form::close() !!}
    				</div>
    			</div>
    		</div>
    	</div>
    @stop