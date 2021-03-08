@extends( 'layouts.app' )

@section('title', 'My Blog Post')

@section('style')
<link rel="stylesheet" href="{{asset('home/summernote/dist/summernote.css')}}">
<style>
  
/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
@endsection

@section('content')
<div style="background-image: url('{{asset('images/bg2.jpg')}}');" class="breadcrumb-section jarallax pixels-bg" data-jarallax data-speed="0.6">
    <div class="container text-center">
        <h1>My Blog Posts</h1>
        <ul>
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="javascript:void(0);">Page</a></li>
            <li><a href="javascript:void(0);">My Blog Posts</a></li>
        </ul>
    </div>
</div>

<div class="section-block">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-12">
                <form id="status_form" action='{{url("user/blog-status")}}' method="POST">
                {{ csrf_field() }}
                    <h4>My Blog Posts</h4><br>
                    <div class="dropdown">
                        <button class="btn btn-primary" type="button">Action</button>
                        <div class="dropdown-content">
                            <li><button class="btn btn-default" name="submit" type="button" onclick="status_form('active')">Active</button></li>
                            <li><button class="btn btn-default" name="submit" type="button" onclick="status_form('inactive')">Inactive</button></li>
                            <!-- <li><button class="btn btn-default" name="submit" type="button" onclick="status_form('featured')">Feature</button></li>
                            <li><button class="btn btn-default" name="submit" type="button" onclick="status_form('unfeatured')">Unfeature</button></li> -->
                            <li class="divider"></li>
                            <li><button class="btn btn-default" name="submit" type="button" style="color: red;" onclick="status_form('delete')">Delete</button></li>
                        </div>
                    </div>
                
                    <button style="float: right" class="btn btn-success" data-toggle="modal" data-target="#blog">New Post</button><br><br>
                        <table id="datatable" class="table table-striped">
                            <thead>
                            <tr>
                                <th><input type="checkbox" onClick="checkAllBlog()" id="chAllCon" /></th>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <!-- <th>Featured</th> -->
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($blog as $bl)
                            <tr>
                                <td><input class="blogBox" type="checkbox" name="id[]" value="{{$bl->id}}" /> </td>
                                <td><img src="{{asset('images/blog/'.$bl->image)}}" style="max-height: 100px; max-width: 100px"></td>
                                <td>{{$bl->title}}</td>
                                <td>{{$bl->cat->name}}</td>
                                @if($bl->status==ACTIVE)
                                <td><span class="badge badge-success">Active</span></td>
                                @else
                                <td><span class="badge badge-warning">Inactive</span></td>
                                @endif
                                <td>{{$bl->views}}</td>
                                {{-- @if($bl->featured==YES)
                                <td><span class="badge badge-success">Yes</span></td>
                                @else
                                <td></td>
                                @endif --}}
                                <td>
                                    <li><a href="javascript:void(0);" style="color: blue" onclick="update({{$bl}})"><i class="fas fa-edit"></i></a></li>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    {{$blog->links('front.pagination')}}
                </form>
            </div>
           @include('includes.user-side')
        </div>
    </div>
</div>



<!-- Create blog -->
<div  id="blog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Blog Post</h4>
            </div>
            <form class="cmxform form-horizontal " id="blog-form">
            {{ csrf_field() }}
            <div class="modal-body">
            <div class="form">

                        <div class="form-group col-lg-12">
                            <label for="title" class="control-label">Blog Post Title</label>
                              <input class=" form-control" name="title" type="text" required="required"/>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="cat_id" class="control-label">Category</label>
                            <select class=" form-control" name="cat_id" required="required">
                                @foreach($category as $ch)
                                 <option value="{{$ch->id}}">{{$ch->name}}</option>
                                 @endforeach

                                </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="full_descrpt" class="control-label">Description</label>
                            <textarea class=" form-control" rows="5" name="description"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="keywords" class="control-label">Keywords</label>
                            <textarea class=" form-control" rows="3" name="keywords"></textarea></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="row">
                                <div class="col-lg-8">
                                    <label for="image" class="control-label">Blog Post Image</label>
                                    <input class=" form-control" id="imgInp" name="image" type="file" required="required"/>
                                </div>
                                <div class="col-lg-4">
                                    <img id="blah" src="" style="max-width: 100px; max-height: 100px"/>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            <div class="modal-footer">
            <input class=" form-control" id="created_by" name="created_by" value="1" type="hidden" required="required"/>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- edit blog -->
<div  id="editmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Blog Post</h4>
            </div>
            <form class="cmxform form-horizontal " id="edit-form">
            {{ csrf_field() }}
            <div class="modal-body">
            <div class="form">

                        <div class="form-group col-lg-12">
                            <label for="title" class="control-label">Title</label>
                            <input class=" form-control" id="edittitle" name="title" type="text" required="required"/>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="cat_id" class="control-label">Category</label>
                            <select class=" form-control" id="editcat" name="cat_id" required="required">
                                @foreach($category as $ch)
                                 <option value="{{$ch->id}}">{{$ch->name}}</option>
                                 @endforeach
                                </select>
                        </div>
                       <div class="form-group col-lg-12">
                            <label for="description" class="control-label">Description</label>
                            <textarea class=" form-control" id="editdescription" rows="5" name="description"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="keywords" class="control-label">Keywords</label>
                            <textarea class=" form-control" rows="3" id="editkeywords" name="keywords"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="row">
                                <div class="col-lg-8">
                                    <label for="image" class="control-label">Blog Image</label>
                                    <input class=" form-control" id="imgInp2" accept="image/*" name="image" type="file"/>
                                </div>
                                <div class="col-lg-4">
                                    <img id="editimage" src="" style="max-width: 100px; max-height: 100px"/>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            <div class="modal-footer">
                <input class=" form-control" id="editid" name="id" type="hidden" required="required"/>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('home/summernote/dist/summernote.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true,
            fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18'],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Roboto'],
            fontNamesIgnoreCheck: ['Roboto'],
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ]
        });
    });

function readURL(input) {

    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
    }
    }

    $("#imgInp").change(function() {
    readURL(this);
});

    $('#blog-form').submit(function(e){
		e.preventDefault();
        $('#blog').modal('hide');
            open_loader('#page');

		var form = $("#blog-form")[0];
		var _data = new FormData(form);
		$.ajax({
			url: '{{url("user/create-blog")}}',
			data: _data,
			enctype: 'multipart/form-data',
			processData: false,
			contentType:false,
			type: 'POST',
			success: function(data){
				//$("#blog").modal("toggle");
				if(data.status == "success"){
					toastr.success(data.message, data.status);
                    $( "#datatable" ).load( "{{url('/user/blog')}} #datatable" );
					//window.setTimeout(function(){location.reload();},2000);
                    close_loader('#page');
                    } else{
                        toastr.error(data.message, data.status);
                        close_loader('#page');
                    }
			},
			error: function(result){
				toastr.error('Check Your Network Connection !!!','Network Error');
                close_loader('#page');
			}
		});
		return false;
    });

    function update(event){
        //$('#modaltitle').text("Update " +event.title)
        $('#edittitle').val(event.title)
        $('#editdescription').val(event.description)
        $('#editcat').val(event.cat_id)
        $('#editkeywords').val(event.keywords)
        $('#editid').val(event.id)
        $("#editimage").attr('src', "{{asset('images/blog')}}/"+event.image)
        $('#editmodal').modal('show')
    }

    $('#edit-form').submit(function(e){
        e.preventDefault();
        $('#editmodal').modal('hide');
            open_loader('#page');

        var form = $("#edit-form")[0];
        var _data = new FormData(form);
        $.ajax({
            url: '{{url("user/update-blog")}}',
            data: _data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType:false,
            type: 'POST',
            success: function(data){
                //$("#service").modal("toggle");
                if(data.status == "success"){
                    toastr.success(data.message);
                    $( "#datatable" ).load( "{{url('/user/blog')}} #datatable" );
                    close_loader('#page');
                    } else{
                        toastr.error(data.message);
                        close_loader('#page');
                    }
            },
            error: function(result){
                toastr.error('Check Your Network Connection !!!','Network Error');
                close_loader('#page');
            }
        });
        return false;
    });

    function status_form(value) {
        open_loader('#page');

		var form = document.getElementById('status_form');
        var _data = new FormData(form);
        _data.append('submit',value);

		$.ajax({
			url: form.action,
			data: _data,
			enctype: 'multipart/form-data',
			processData: false,
			contentType:false,
			type: form.method,
			success: function(data){
				//$("#blog").modal("toggle");
				if(data.status == "success"){
                    toastr.success(data.message, data.status);
                    $( "#datatable" ).load( "{{url('/user/blog')}} #datatable" );
					//window.setTimeout(function(){location.reload();},2000);
                    close_loader('#page');
                    } else{
                        toastr.error(data.message, data.status);
                        close_loader('#page');
                    }
			},
			error: function(result){
				toastr.error('Check Your Network Connection !!!','Network Error');
                close_loader('#page');
			}
		});
		return false;
    }

    function checkAllBlog(){
    var ch =document.getElementById('chAllCon').checked,
    checked = false;
    if(ch){
        checked=true;
    }
        var els = document.getElementsByClassName('blogBox');

        for(var g=0;g<els.length;g++){
            els[g].checked=checked;
        }


    }
</script>
@endsection
