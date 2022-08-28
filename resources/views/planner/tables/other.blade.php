<form action="{{ route('storeOther')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Service:</label>
        <div class="col-lg-9">
            <select id="package_other_id" name="package_other_id" class="@error('package_other_id') is-invalid @enderror form-control select2">
                <option value="">Select Service</option>
                @foreach ($package_others as $package_other)
                    <option value="{{ $package_other->id }}" {{ ($package_other->id == old("package_other_id")) ? " selected" : "" }}>{{ ucwords($package_other->name) }} - {{ Str::currency($package_other->service_price) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-bordered" id="planner-package-others-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>SERVICE</th>
                <th>SERVICE FEE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>