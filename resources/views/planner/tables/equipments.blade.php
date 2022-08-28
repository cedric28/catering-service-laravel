<form action="{{ route('storeEquipment')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Equipment:</label>
        <div class="col-lg-9">
            <select id="package_equipment_id" name="package_equipment_id" class="@error('package_equipment_id') is-invalid @enderror form-control select2">
                <option value="">Select Equipment</option>
                @foreach ($package_equipments as $package_equipment)
                    <option value="{{ $package_equipment->id }}" {{ ($package_equipment->id == old("package_equipment_id")) ? " selected" : "" }}>{{ ucwords($package_equipment->package_equipment->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-bordered" id="planner-package-equipments-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>EQUIPMENT NAME</th>
                <th>REQUIRED QUANTITY</th>
                <th>CURRENT QUANTITY</th>
                <th>RETURNED QUANTITY</th>
                <th>REMARKS</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>