<form action="{{ route('storeTimeTable')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Tasks:</label>
        <div class="col-lg-9">
            <input type="text" name="task_name" value="{{ old('task') }}" class="@error('task') is-invalid @enderror form-control" placeholder="e.g Dinner">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Task Time:</label>
        <div class="col-lg-9">
        <div class="input-group date" id="timetable" data-target-input="nearest">
            <input type="text" name="task_time" value="{{ old('time') }}" placeholder="e.g 8:27 PM" onkeydown="return false;" class="@error('task_date') is-invalid @enderror form-control datetimepicker-input" data-target="#timetable"/>
            <div class="input-group-append" data-target="#timetable" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
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
                <th>TIME</th>
                <th>TASK</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>