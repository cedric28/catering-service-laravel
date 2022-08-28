<form action="{{ route('storeTask')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Tasks:</label>
        <div class="col-lg-9">
            <select id="package_task_id" name="package_task_id" class="@error('package_task_id') is-invalid @enderror form-control select2">
                <option value="">Select Task</option>
                @foreach ($package_tasks as $task)
                    <option value="{{ $task->id }}"{{ ($package->id == old('package_task_id')) ? ' selected' : '' }}>{{ ucwords($task->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Task Date & Time:</label>
        <div class="col-lg-9">
        <div class="input-group date" id="taskdate" data-target-input="nearest">
            <input type="text" name="task_date" value="{{ old('task_date') }}" placeholder="e.g 2022-08-20 8:27 PM" onkeydown="return false;" class="@error('task_date') is-invalid @enderror form-control datetimepicker-input" data-target="#taskdate"/>
            <div class="input-group-append" data-target="#taskdate" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Staff:</label>
        <div class="col-lg-9">
            <select id="user_id" name="user_id" class="@error('user_id') is-invalid @enderror form-control select2">
                <option value="">Select Staff</option>
                @foreach ($usersHeadStaff as $user)
                    <option value="{{ $user->id }}"{{ ($user->id == old('user_id')) ? ' selected' : '' }}>{{ ucwords($user->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Task Type:</label>
        <div class="col-lg-9">
            <select id="task_type" name="task_type" class="@error('task_type') is-invalid @enderror form-control select2">
                <option value="">Select Type</option>
                @foreach ($task_types as $task_type)
                    <option value="{{ $task_type['type'] }}" {{ ($task_type["type"] == old("task_type")) ? " selected" : "" }}>{{ ucwords($task_type['type']) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-bordered" id="planner-package-tasks-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>TASK</th>
                <th>DATE & TIME</th>
                <th>STAFF/S</th>
                <th>TYPE</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

@push('scripts')
<script>

</script>
@endpush('scripts')