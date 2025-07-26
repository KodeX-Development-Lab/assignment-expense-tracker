<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('category') ? ' has-error' : ''}}">
            <div class="list-title mb-3">
                {!! Form::label('category', 'Category: ', ['class' => 'control-label']) !!}
            </div>
           {!! Form::select('category_id', $categories, null , ['class' => 'form-select', 'data-control' => 'select2', 'data-placeholder' => "Select Category", 'placeholder' => "Select Category", "data-kt-ecommerce-product-filter" => "category_id"]) !!}
            {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <div class="form-group">
                <div class="float-left">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-save"></i>
                        Save</button>
                    <button type="button" class="btn btn-secondary btn-sm cancel" onclick="window.location='{{ url('/admin/users')}}'"><i class="bi bi-x"
                            aria-hidden="true"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
