<form action="{{ route('storeStaffing')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Staff:</label>
        <div class="col-lg-9">
            <select id="user_id" name="user_id" class="@error('user_id') is-invalid @enderror form-control select2">
                <option value="">Select Staff</option>
                @foreach ($usersStaffJobTypes as $user)
                    <option value="{{ $user->id }}"{{ ($user->id == old('user_id')) ? ' selected' : '' }}>{{ ucwords($user->name) }} - {{ ucwords($user->job_type->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-bordered" id="planner-package-staffing-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>NAME</th>
                <th>ATTENDANCE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>