@extends('layout')
@section('child_head')
    <link rel="stylesheet" href={{ asset('css/ajax/libs/jqueryui/jquery-ui.css') }}>
    <script src= {{ asset('js/ajax/libs/jquery/jquery.min.js') }}></script>
    <script src= {{ asset('js/ajax/libs/jqueryui/jquery-ui.min.js') }}></script>
@endsection
@section('child_content')
    <div id ="editRequest" class="container-fluid">
        <div class=" panel panel-default" >
            <div class="panel-heading ">
                <label class="h4 col-md-7"><span class="glyphicon glyphicon-globe"></span>{{$request->title}}</label>
                <div class="btn-toolbar">
                    <button type="button" class=" btn btn-default" title="Thay đổi bộ phận IT" onclick="edit('#team')"><span class="glyphicon glyphicon glyphicon-cd small "></span></button>
                    <button type="button" class=" btn btn-default" title="Thay đổi mức độ ưu tiên" onclick="edit('#priority')"><span class="glyphicon glyphicon-retweet small"></span></button>
                    <button type="button" class=" btn btn-default" title="Thay đổi deadline" onclick="edit('#deadline')"><span class="glyphicon glyphicon-calendar small"></span></button>
                    <button type="button" class=" btn btn-default" title="Assign" onclick="edit('#assigned_to')"><span class="glyphicon glyphicon-hand-right small"></span></button>
                    <button type="button" class=" btn btn-default" title="Thay đổi người liên quan" onclick="edit('#relater')"><span class="glyphicon glyphicon-user small"></span></button>
                    <button type="button" class=" btn btn-default" title="Thay đổi trạng thái" onclick="edit('#status')"><span class="glyphicon glyphicon-transfer"></span></button>
                </div>
            </div>
            <div class="panel-body">
                <form action="" method="post" id="editForm">
                    <div class="row">
                    {{--can them action vào form--}}
                    {{--them gia trị ban dau cua cac form--}}
                        <div class="col-md-6">
                            <label class="col-md-5" id="createDate">Ngày tạo:</label>
                            {{--<span class="col-md-7">jfhfdfkjhksdhf</span>--}}
                            <span class="col-md-7">{{$request->created_at}}</span>

                        </div>
                        <div class="col-md-6">
                            <label class="col-md-5">Ngày hết hạn:</label>
                            {{--<span class="col-md-7">jfhfdfkjhksdhf</span>--}}
                            {{--<input id="deadline" type= 'date' name="deadline" class="form-control col-md-7" placeholder="old dateline"/>--}}
                            <span class="col-md-7">{{$request->deadline}}</span>
                            <input id="deadline" type= 'date' name="deadline" class="form-control col-md-7" value={{$request->deadline}} placeholder={{$request->deadline}}>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-5" id="createBy">Người yêu cầu:</label>
                            {{--<span class="col-md-7">{{$request->create_by}}</span>--}}
                            <span class="col-md-7">{{$createBy}}</span>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-5">Người thực hiện:</label>
                            {{--<span class="col-md-7">jfhfdfkjhksdhf</span>--}}
                            {{--<input id="assigned_to" class="form-control col-md-7" type="text" >--}}
                            <span class="col-md-7">{{$assignedTo}}</span>
                            <input id="assigned_to" class="form-control col-md-7" type="text" placeholder="{{$assignedTo}}">
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-6">
                            <label class="col-md-5">Mức độ ưu tiên:</label>
                            {{--<span class="col-md-7">jfhfdfkjhksdhf</span>--}}
                            <span class="col-md-7">{{env('priority.'.$request->priority)}}</span>
                            {{--<select class="form-control col-md-7" id="priority" name="priority" >--}}
                                {{--<option value="1">{{env('priority.1')}}</option>--}}
                                {{--<option value="2">{{env('priority.2')}}</option>--}}
                                {{--<option value="3">{{env('priority.3')}}</option>--}}
                                {{--<option value="4">{{env('priority.4')}}</option>--}}
                            {{--</select>--}}

                            <select class="form-control col-md-7" id="priority" name="priority" value={{$request->priority}}>
                                <option value="1">{{env('priority.1')}}</option>
                                <option value="2">{{env('priority.2')}}</option>
                                <option value="3">{{env('priority.3')}}</option>
                                <option value="4">{{env('priority.4')}}</option>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label class="col-md-5">Trạng thái:</label>
                            {{--<span class="col-md-7">jfhfdfkjhksdhf</span>--}}

                            <span class="col-md-7">{{env('status.'.$request->status)}}</span>
                            <select class="form-control col-md-7" id="status" name="status">
                                <option value="1">{{env('status.1')}}</option>
                                <option value="2">{{env('status.2')}}</option>
                                <option value="3">{{env('status.3')}}</option>
                                <option value="4">{{env('status.4')}}</option>
                            </select>
                            {{--<select class="form-control col-md-7" id="status" name="status" value={{$request->status}}>--}}
                                {{--<option value="1">New</option>--}}
                                {{--<option value="2">Close</option>--}}
                                {{--<option value="3">Resolve</option>--}}
                            {{--</select>--}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-5">Bộ phận IT:</label>
                            {{--<span class="col-md-7">jfhfdfkjhksdhf</span>--}}
                            <span class="col-md-7">{{$requestTeam}}</span>

                            <select class="form-control col-md-7" id="team" name="team">
                                <?php
                                foreach($teams as $team){
                                ?>
                                <option value="{{ $team->id }}"> {{ $team->name }} </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-5">Người liên quan</label>
                            <span class="col-md-7">jfhfdfkjhksdhf</span>
                            {{--<span class="col-md-7">{{$relaters->name}}</span>--}}

                            {{--tao nguoi lien quan theo list co cuon --}}
                            {{--c1: dung select voi thuoc tinh size--}}
                            {{--c2: dung danh sach goi y--}}

                            <input id="relater" class="form-control col-md-7" type="text">

                            {{--<input id="relater" class="form-control col-md-7" type="text" value = {{$request->relater}} placeholder={{$request->relater}}>--}}

                        </div>
                    </div>
                        <div class="btn-toolbar col-md-3 pull-right">
                        <button type="button" class="btn-primary" style="margin-top: 5px" id="save">save</button>
                        <button type="button" class="btn-primary " style="margin-top: 5px" id="cancel" >cancel</button>
                        </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <label class="h4 col-offset-2"><span class="glyphicon glyphicon-file"></span>Noi dung</label>
            </div>
            <div class="panel panel-body col-md-12">
                //binh luan
                <a href="#">Hiển thị thêm bình luận</a>
            </div>
            <div class=" panel panel-body">
                <div ><label class="control-label h4"><span class="glyphicon glyphicon-edit"></span>Binh luan</label></div>
                <div>
                    <ul class="nav nav-pills">
                        <li ><a>Bold</a></li>
                        <li><a>Italic</a></li>
                        <li><a>Messages</a></li>
                    </ul>
                </div>
                <div >
                    <form id="comment">
                        <textarea type="text" class="form-control" id="requestContent" rows = '10' name="comment" ></textarea>
                        {{ csrf_field() }}
                    </form>
                </div>
                <button class="btn btn-primary">Bình luận</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
            document.write("adfsdf");
            $('#priority').hide();
            $('#deadline').hide();
            $('#team').hide();
            $('#assigned_to').hide();
            $('#relater').hide();
            $('#status').hide();
            $('#save').hide();
            $('#save').click(save);
            $('#cancel').hide();
            $('#cancel').click(cancel);

        //sử dụng autocomplete với input có id = key
        $( "#relater")
            .on("keydown", function( event ) {
                //document.write("sdfasd");
                 if ( event.keyCode === 9 &&
                     $(this).autocomplete( "instance" ).menu.active ) {
                      event.preventDefault();
                }
            })
            .autocomplete({
                source: function( request, response ) {
                    $.getJSON( '{{url('search/autocomplete/editRequest/'.$request->id)}}', {
                        term: extractLast( request.term )
                    }, response );
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                }
            });
        function extractLast( term ) {
            return split( term ).pop();
        }
        function split( val ) {
            return val.split( /,\s*/ );
        }

        function edit(id){
            $(id).prev().hide();
            $(id).show();
            $('#save').show();
            $('#cancel').show();

        };
        function cancel(){
            alert($("#relater").val());
            // an phan chinh sua
            $('#priority').hide();
            $('#deadline').hide();
            $('#team').hide();
            $('#assigned_to').hide();
            $('#relater').hide();
            $('#status').hide();
            $('#save').hide();
            $('#cancel').hide();
            //thiet lap lai gia tri ban dau:
            $('#priority').val('{{$request->priority}}');
            $('#deadline').val('{{$request->deadline}}');
            $('#team').val('{{$request->team_id}}');
            $('#assigned_to').val({{$request->assigned_to}});
            $('#relater').val({{$request->relater}});
            $('#status').val({{$request->status}});
            //hien thi lai gia tri cu
            $('#priority').prev().show();
            $('#deadline').prev().show();
            $('#team').prev().show();
            $('#assigned_to').prev().show();
            $('#relater').prev().show();
            $('#status').prev().show();
        }
        function save(){
            if(confirm("Bạn có thực sự muốn lưu không?")){
                $('#editForm').submit();
              //  location.reload();
            }
        }
        function comment(){
            $('#comment').submit();
        }
    </script>
@endsection