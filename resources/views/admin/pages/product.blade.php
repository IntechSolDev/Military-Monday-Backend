@extends('admin.layouts.layouts')
@section('content')
<style>
.badge {
    padding: 0.8em 2em;
}
    .btn-status {
    cursor: pointer;
}
</style>
    <div class="container-fluid">
        <!-- Breadcrumbs-->
           <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/admin/')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Product</li>
        </ol>
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="pd-20">
                <div class="modal fade bs-example-modal-lg" id="ajaxModel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modelHeading">Add new Product</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form method="post" id="ItemForm" name="ItemForm"  enctype="multipart/form-data">
                                <input type="hidden" name="Item_id" id="Item_id">
                                <!--<input type="hidden" name="user_id" id="user__id">-->
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input class="form-control" type="text" id="name" name="name">
                                            </div>
                                        </div>
                               
                                    
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" type="text" id="description" name="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input  class="form-control" type="number" min="1"   id="quantity" name="quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input  class="form-control" type="number" min="1"  step="any" id="price" name="price">
                                            </div>
                                        </div>
                                         <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Discount Price</label>
                                                <input  class="form-control" type="number" min="1"  step="any" id="discount_price" name="discount_price">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Discount Percent</label>
                                                <input  class="form-control" type="number" min="1"  step="any" id="discount_percent" name="discount_percent">
                                            </div>
                                        </div>
                                        
                                         <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Product Type</label>
                                                  <input class="form-control" type="text" id="type" name="type">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Date</label>
                                                  <input class="form-control" type="text" id="date" name="date">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Start Time</label>
                                                  <input class="form-control" type="text" id="start_time" name="start_time">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>End Time</label>
                                                  <input class="form-control" type="text" id="end_time" name="end_time">
                                            </div>
                                        </div>
                                         <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Store</label>
                                                  <input class="form-control" type="text" id="store" name="store">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Store Url</label>
                                                  <input class="form-control" type="text" id="store_url" name="store_url">
                                            </div>
                                        </div>
                                       
                                  
                                   
                                        <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" id="image" name="image"
                                                   class="form-control-file form-control height-auto"
                                                   accept="image/*" onchange="readURL('image-modal-preview','image_hidden','image');">
                                            <input type="hidden" class="emptyImage" name="image_hidden"
                                                   id="image_hidden">
                                            <img id="image-modal-preview"
                                                 src="https://via.placeholder.com/150" alt="Preview"
                                                 class="form-group hidden" width="100" height="100">
                                        </div>
                                        </div>
                               
                                        <div class="col-md-3 col-sm-12 mt-3">
                                            <div class="form-group">
                                                <label for="product_status">Product Status</label>
                                                      <select name="product_status" class="form-control" id="product_status">
                                                        <option value="pending">Pending</option>
                                                        <option value="active">Active</option>
                                                      </select>
      
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="action_button" id="saveBtn" value="create" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <i class="fas fa-table"></i>
                        Product
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered data-table-level"  width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Creator</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                             <th>Date</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                            <th class="datatable-nosort" >Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!--End Section -->
        @endsection
        @section('page-script')
            <script type="text/javascript">
                $(function () {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var table = $('.data-table-level').DataTable({
                        dom: 'Bfrtip',
                        "buttons": [
                            {
                                "extend": 'excel',
                                "text": '<i class="fa fa-file-excel" style="color: green;"> Excel</i>',
                                "titleAttr": 'Excel',
                                "action": newexportaction,
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                "extend": 'csv',
                                "text": '<i class="fa fa-file" style="color: green;"> Csv</i>',
                                "titleAttr": 'CSV',
                                "action": newexportaction,
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                "extend": 'pdf',
                                "text": '<i class="fa fa-file-pdf" style="color: green;"> Pdf</i>',
                                "titleAttr": 'PDF',
                                "action": newexportaction,
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                "extend": 'print',
                                "text": '<i class="fa fa-print" style="color: green;"> Print</i>',
                                "titleAttr": 'Print',
                                "action": newexportaction,
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            'colvis'],
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('product.index') }}",
                        scrollCollapse: true,
                        autoWidth: false,
                        responsive: true,
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        language: {
                            info: "_START_-_END_ of _TOTAL_ entries",
                            searchPlaceholder: "Search",

                        },
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                            {data: 'user.username', name: 'user.username'},
                            {data: 'image', name: 'image'},
                            {data: 'name', name: 'name'},
                            {data: 'price', name: 'price'},
                            {data: 'date', name: 'date'},
                            {data: 'start_time', name: 'start_time'},
                            {data: 'end_time', name: 'end_time'},
                             {data: 'status', name: 'status'},
                            // {data: 'product_status', render: function(data) {  
                            // if(data == 'active') 
                            //     return '<span class="badge badge-primary">Active</span>'; 
                            // else if(data == 'pending') 
                            //     return '<span class="badge badge-warning">Pending</span>'; 
                            // else if(data == 'sold') 
                            //     return '<span class="badge badge-success">Sold Out</span>'; 
                            // else if(data == 'expired') 
                            //     return '<span class="badge badge-danger">Expired</span>'; 
                            // else
                            //      return '';
                                
                            // }},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                        ]

                    });
                    $("#import_file").change(function(){
                        $('input').removeAttr('required');
                    });

//Create New Product
                    $('#createNewItem').click(function () {
                        $('.ajax-loader').css("visibility", "visible");
                        $('#image-container').empty();
                        $('#saveBtn').show();
                        $('.csv-import').show();
                        $('input').attr('readonly', false);
                        $('textarea').attr('readonly', false);
                        $('input:radio').attr('disabled', false);
                        $("input[type=text]").attr('required', true);
                        $("input[type=number]").attr('required', true);
                        $('#image-modal-preview1').attr('src', 'https://via.placeholder.com/150');
                        $('#image-modal-preview2').attr('src', 'https://via.placeholder.com/150');
                        $('#saveBtn').val("create-Item");
                        $('#Item_id').val('');
                        $('#ItemForm').trigger("reset");
                        $('#modelHeading').html("Create New Product");
                        $('#ajaxModel').modal('show');
                        $('.ajax-loader').css("visibility", "hidden");
                    });

//Submit Edit and Create
                    $('body').on('submit', '#ItemForm', function (e) {
                        e.preventDefault();
                        $('#saveBtn').html('Sending..');
                        $('.ajax-loader').css("visibility", "visible");
                        var formData = new FormData(this);
                        $.ajax({
                            data: formData,
                            url: "{{ route('product.store') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function (data) {
                                $('#saveBtn').html('Save Changes');
                                $('#ItemForm').trigger("reset");
                                alert(data.success);
                                $('#ajaxModel').modal('hide');
                                $('.ajax-loader').css("visibility", "hidden");
                                table.draw();
                            },
                            error: function (data) {
                                $('.ajax-loader').css("visibility", "hidden");
                                alert(data.error);
                                $('#saveBtn').html('Save Changes');
                            }
                        });
                    });





//Set Expire Date
                    $('body').on('click', '#set-expirebtn', function (e) {
                             e.preventDefault();
                       $('.ajax-loader').css("visibility", "visible");
                       let expire_days =  $('#set_expire').val();
                       if(expire_days == '' || expire_days == 0)
                       {
                           alert('Expire Days must be greater than 0');
                           $('.ajax-loader').css("visibility", "hidden");
                           return false;
                       }

                        $.post("{{ route('product.set_expire_days') }}",
                        {
                             expire_days: expire_days,
                            _token: jQuery('meta[name="csrf-token"]').attr('content')
                        },
                        function (data, status) {
                                alert('Expire Date Set on All product Successfully');
                                $('.ajax-loader').css("visibility", "hidden");
                        });
                           $('.ajax-loader').css("visibility", "hidden");
                    });

//Status Change

                    $('body').on('click', '.btn-status', function () {

                        var Item_id = $(this).data("id");

                        if (confirm("Are You sure want to change Status !")) {
                            $.ajax({
                                type: "GET",
                                url: "{{ route('product.changestatus') }}" + '/' + Item_id,
                                success: function (data) {
                                    table.draw();
                                    // alert(data.message);
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                }
                            });
                        }

                    });




//Edit
                    $('body').on('click', '.editItem', function () {
                        $('.ajax-loader').css("visibility", "visible");
                        $('#saveBtn').show();
                        $('.csv-import').hide();
                        $('input').attr('readonly', false);
                        $('textarea').attr('readonly', false);
                        $('input:radio').attr('disabled', false);
                        $('#image-modal-preview1').attr('src', 'https://via.placeholder.com/150');
                        $('#image-modal-preview2').attr('src', 'https://via.placeholder.com/150');
                        var Item_id = $(this).data('id');
                        $.get("{{ route('product.index') }}" +'/' + Item_id +'/edit', function (data) {
                            $('#modelHeading').html("Edit Product");
                            $('#saveBtn').val("edit-product");
                            $('#ajaxModel').modal('show');
                            $('#Item_id').val(data.id);
                            $('#name').val(data.name);
                            $('#price').val(data.price);
                            $('#location_id').val(data.location_id);
                            $('#category_id').val(data.category_id);
                            $('#sub_category_id').val(data.sub_category_id);
                            $('#phoneno').val(data.phoneno);
                            $('#description').val(data.description);
                            $('#address').val(data.address);
                            if (data.image1) {
                                var image_url = data.image1;
                                $('#image-modal-preview1').attr('src',image_url);
                                var parts = image_url.split("/");
                                var last_part = parts[parts.length-1];
                                $('#image_hidden1').val(last_part);
                            }
                            if (data.image2) {
                                var image_url = data.image2;
                                $('#image-modal-preview2').attr('src',image_url);
                                var parts = image_url.split("/");
                                var last_part = parts[parts.length-1];
                                $('#image_hidden2').val(last_part);
                            }
                            $("#product_status").val(data.product_status);
                            $('.ajax-loader').css("visibility", "hidden");
                        })
                    });

//View
                    $('body').on('click', '.viewItem', function () {
                        $('.ajax-loader').css("visibility", "visible");
                        $('#image-modal-preview1').attr('src', 'https://via.placeholder.com/150');
                        $('#image-modal-preview2').attr('src', 'https://via.placeholder.com/150');
                        var Item_id = $(this).data('id');
                        $.get("{{ route('product.index') }}" +'/' + Item_id +'/edit', function (data) {
                            $('#modelHeading').html("View Product");
                            $('#saveBtn').hide();
                            $('.csv-import').hide();
                            $('#ItemForm input').attr('readonly', true);
                            $('#ItemForm textarea').attr('readonly', true);
                            $('#ItemForm #thumbnail_image').hide();
                            $('#ItemForm input:radio').attr('disabled', true);
                            $('#ajaxModel').modal('show');
                            $('#Item_id').val(data.id);
                            $('#sku').val(data.sku);
                            $('#name').val(data.name);
                            $('#price').val(data.price);
                            $('#final_price').val(data.final_price);
                            $('#description').val(data.description);
                            $('#discount_price').val(data.discount_price);
                            $('#discount_percent').val(data.discount_percent);
                            $('#quantity').val(data.quantity);
                            $('#type').val(data.type);
                            $('#url').val(data.url);
                            $('#start_time').val(data.start_time);
                            $('#end_time').val(data.end_time);
                            $('#store').val(data.store);
                            $('#store_url').val(data.store_url);
                            $('#date').val(data.date);
                            if (data.image) {
                                var image_url = data.image;
                                $('#image-modal-preview').attr('src',image_url);
                                var parts = image_url.split("/");
                                var last_part = parts[parts.length-1];
                                $('#image_hidden').val(last_part);
                            }
                            $("#product_status").val(data.product_status);
                            $('.ajax-loader').css("visibility", "hidden");
                        })

                    });

//Delete
                    $('body').on('click', '.deleteItem', function () {

                        var Item_id = $(this).data("id");

                        if( confirm("Are You sure want to delete !"))
                        {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('product.store') }}"+'/'+Item_id,
                                success: function (data) {
                                    table.draw();
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                }
                            });
                        }
                    });
                });
/* For Export Buttons available inside jquery-datatable "server side processing" - Start
                - due to "server side processing" jquery datatble doesn't support all data to be exported
                - below function makes the datatable to export all records when "server side processing" is on */
                function readURL(preview,hidden,id) {
                    var $i = $("#" + id), // Put file input ID here
                        input = $i[0]; // Getting the element from jQuery
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("#" + preview).attr('src', e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                        $("#" + preview).removeClass(hidden);
                        $('#start').hide();
                    }
                }
                function newexportaction(e, dt, button, config) {
                    var self = this;
                    var oldStart = dt.settings()[0]._iDisplayStart;
                    dt.one('preXhr', function (e, s, data) {
                        // Just this once, load all data from the server...
                        data.start = 0;
                        data.length = 2147483647;
                        dt.one('preDraw', function (e, settings) {
                            // Call the original action function
                            if (button[0].className.indexOf('buttons-copy') >= 0) {
                                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                            }
                            dt.one('preXhr', function (e, s, data) {
                                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                                // Set the property to what it was before exporting.
                                settings._iDisplayStart = oldStart;
                                data.start = oldStart;
                            });
                            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                            setTimeout(dt.ajax.reload, 0);
                            // Prevent rendering of the full data to the DOM
                            return false;
                        });
                    });
                    // Requery the server with the new one-time export settings
                    dt.ajax.reload();
                };
                //For Export Buttons available inside jquery-datatable "server side processing" - End
            </script>
@endsection
