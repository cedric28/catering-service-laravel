<!--- Add Task Modal -->
<div id="addFoodModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog">
        <form id="foodData">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100"><span id="foodTitle"></span></h4>
                    <button type="button" class="close float-right" onclick="closeFoodModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h5 align="center" class="w-100"><span class="text-danger" id="generalFoodError"></span></h5>
                    <input type="hidden" id="food_id" name="food_id" value="">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Food Category:</label>
                        <div class="col-lg-9">
                            <select id="category_id" name="category_id" class="@error('category_id') is-invalid @enderror form-control select2">
                                <option value="">Select Food Category</option>
                                @foreach ($food_categories as $category)
                                    <option value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>		
                </div>
                <div class="modal-footer">
                <button type="button" name="add_food_button" id="add_food_button" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" onclick="closeFoodModal()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
   //add food
   var tableFood = $('#package-foods-lists').DataTable({
				"responsive": true, 
				"lengthChange": false, 
				"autoWidth": false,
      			"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url":"<?= route('activePackageFood') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{
						"_token":"<?= csrf_token() ?>",
						"package_id": packageId
					}
                },
				"dom": 'Bfrtip',
                "buttons": [
                    {
                        "extend": 'collection',
                        "text": 'Export',
                        "buttons": [
                            {
                                "extend": 'csv',
                                'title' :`PACKAGE-${packageName}-FOOD-MENU`,
                                "exportOptions": {
                                    "columns": [0,1]
                                }
                            },
                            {
                                "extend": 'pdf',
								'title' :`PACKAGE-${packageName}-FOOD-MENU`,
                                "exportOptions": {
                                    "columns": [0,1]
                                }
                            },
                            {
                                "extend": 'print',
								'title' :`PACKAGE-${packageName}-FOOD-MENU`,
                                "exportOptions": {
                                    "columns": [0,1]
                                }
                            }
                        ],
                    }
                ],
                "columns":[
                    {"data":"name"},
					{"data":"created_at"},
                    {"data":"action","searchable":false,"orderable":false}
                ],
				"columnDefs": [
				{
					"targets": [0,1],   // target column
					"className": "textCenter",
				}
				]
            });

			function closeFoodModal() {
					$("#foodData").trigger("reset");
					$("#foodData input:hidden").val("");
					$("#category_id").removeClass("is-invalid");
					$('#generalFoodError').text("");
					$(`select[name^="category_id"] option:selected`).removeAttr("selected");
			}
			
			$(document).on('click', '#add-food', function(event){
				event.preventDefault();
				$('#foodTitle').html("Add New Food");
                $('#addFoodModal').modal('show');
            });

			$(document).on('click', '#edit-food-package', function(event){
				event.preventDefault();
				$('#foodTitle').html("Update Food Detail");
				let foodId = $(this).attr('data-id');
				let categoryId = $(this).attr('data-category-id');
				$('#food_id').val(foodId);
				$(`select[name^="category_id"] option[value=${categoryId}]`).attr("selected","selected");
                $('#addFoodModal').modal('show');
            });

			$('#add_food_button').click(function(event){
				event.preventDefault();
				let category_id = $( "#category_id option:selected" ).val();
				let food_id = $("#food_id").val();
                console.log({
                    category_id,
                    food_id,
                    package_id: packageId
                })
                $.ajax({
                    url:"<?= route('addFood') ?>",
					dataType:"json",
                    type:"POST",
					data:{
						"_token":"<?= csrf_token() ?>",
						"category_id": category_id,
						"package_id": packageId,
						"food_id": food_id
					},
                    beforeSend:function(){
                        $('#add_food_button').text('Saving...');
                    },
                    success:function(data)
                    {
                       
							$("#foodData").trigger("reset");
                            $('#addFoodModal').modal('hide');
							tableFood.ajax.reload();
                            $('#add_food_button').text('OK');
							$("#category_id").removeClass("is-invalid");
							$('#generalFoodError').text("");
							$("#foodData input:hidden").val("");
							$(`select[name^="category_id"] option:selected`).removeAttr("selected");
                        
						
                    },
					error:function(err){
						if(err.responseJSON){
							let receivedMessage = err.responseJSON.data;
							$('#generalFoodError').text(receivedMessage.category_id[0]);
							$("#category_id").addClass("is-invalid");
							$('#add_food_button').text('Save');
						}
					}
                })
            });
</script>
@endpush('scripts')