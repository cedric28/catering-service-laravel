<form action="{{ route('storeFood')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <div class="row">
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header-elements-inline">
                                <h5 class="card-title">Main Dish</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($package_menus as $menu)
                                @if($menu->package_food_category->dish_category->id == 1)
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="{{ $menu->package_food_category->name }}" name="foods[]"  {{ ($planner->package_menus->contains($menu)) ? 'checked' : '' }} value="{{ $menu->id }}" class="main-dish">
                                        <label for="{{ $menu->package_food_category->name}}">
                                            {{ $menu->package_food_category->name}}
                                        </label>
                                    </div>
                                    <!-- <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="{{ $menu->package_food_category->name }}">
                                        <label class="custom-control-label" for="{{ $menu->package_food_category->name }}">{{ $menu->package_food_category->name}} </label>
                                    </div> -->
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header-elements-inline">
                                <h5 class="card-title">Secondary Dish</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($package_menus as $menu)
                                @if($menu->package_food_category->dish_category->id == 2)
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="{{ $menu->package_food_category->name }}" name="foods[]"  {{ ($planner->package_menus->contains($menu)) ? 'checked' : '' }} value="{{ $menu->id }}" class="second-dish">
                                        <label for="{{ $menu->package_food_category->name}}">
                                            {{ $menu->package_food_category->name}}
                                        </label>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header-elements-inline">
                                <h5 class="card-title">Other Dish</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($package_menus as $menu)
                                @if($menu->package_food_category->dish_category->id == 3)
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="{{ $menu->package_food_category->name }}" {{ ($planner->package_menus->contains($menu)) ? 'checked' : '' }} name="foods[]" value="{{ $menu->id }}">
                                        <label for="{{ $menu->package_food_category->name}}">
                                            {{ $menu->package_food_category->name}}
                                        </label>
                                    </div>
                                    <!-- <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">{{ $menu->package_food_category->name}} </label>
                                    </div> -->
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
@push('scripts')
<script>
    $(".main-dish").change(function() {
        $(".main-dish").not(this).prop('checked', false);
    });
    $(".second-dish").change(function() {
        $(".second-dish").not(this).prop('checked', false);
    });
    // $(".main-dish").change(function() {
    //     $(".main-dish").prop('checked', false);
    //     $(this).prop('checked', true);
    // });

    // $(".second-dish").change(function() {
    //     $(".second-dish").prop('checked', false);
    //     $(this).prop('checked', true);
    // });
</script>

@endpush('scripts')