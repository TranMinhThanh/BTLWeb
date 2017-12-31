@extends('layout')
@section('child_head')
    <link rel="stylesheet" href={{ asset('css/ajax/libs/jqueryui/jquery-ui.css') }}>

    <script src= {{ asset('js/ajax/libs/jquery/jquery.min.js') }}></script>
    <script src= {{ asset('js/ajax/libs/jqueryui/jquery-ui.min.js') }}></script>
    {{--<style>--}}
        {{--.ui-autocomplete-loading {--}}
            {{--background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;--}}
        {{--}--}}
        {{--</style>--}}
@endsection

@section('child_content')
    <div id ="editRequest" class="container-fluid">
        <div class=" panel panel-default" >
            <div class="panel-heading ">
                <label class="h4 col-md-7"><span class="glyphicon glyphicon-globe"></span>{{ $request->title }}</label>
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
                <form method="post" id="editForm" action="{{ route('editRequest') }}">
                    {{ csrf_field() }}
                    <input id="id" name="id" value="{{$request->id}}" hidden/>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-5" id="createDate">Ngày tạo:</label>
                            <span class="col-md-7">{{ $request->created_at }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-5">Ngày hết hạn:</label>
                            <span class="col-md-7">{{$request->deadline}}</span>
                            <input id="deadline" type="date" name="deadline" class="form-control col-md-7" value={{$request->deadline}}>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-5" id="createBy">Người yêu cầu:</label>
                            <span class="col-md-7">{{$request['relations']['create_by']->name}}</span>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-5">Người thực hiện:</label>
                            <span class="col-md-7">{{$request['relations']['assign_to'] == null ? '' : $request['relations']['assign_to']->name}}</span>
                            <input id="assigned_to" class="form-control col-md-7" type="text" placeholder="Người xử lý công việc" value={{$request['relations']['assign_to'] == null ? '' : $request['relations']['assign_to']->name}}>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-6">
                            <label class="col-md-5">Mức độ ưu tiên:</label>
                            <span class="col-md-7">{{env('priority.'.$request->priority)}}</span>
                            <select class="form-control col-md-7" id="priority" name="priority" >
                                <option value="1">{{env('priority.1')}}</option>
                                <option value="2">{{env('priority.2')}}</option>
                                <option value="3">{{env('priority.3')}}</option>
                                <option value="4">{{env('priority.4')}}</option>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label class="col-md-5">Trạng thái:</label>
                            <span class="col-md-7">{{env('status.'.$request->status)}}</span>
                            <select class="form-control col-md-7" id="status" name="status">
                                <option value="1">{{env('status.1')}}</option>
                                <option value="2">{{env('status.2')}}</option>
                                <option value="3">{{env('status.3')}}</option>
                                <option value="4">{{env('status.4')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-5">Bộ phận IT:</label>
                            <span class="col-md-7">{{$request['relations']['team']->name}}</span>

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

                            <span class="col-md-7">
                                  <?php
                                    foreach ($relaters as $relater){
                                  ?>
                                        {{$relater['relations']['user_id']->name.'['.$relater['relations']['user_id']->user_id.'],'}}
                                  <?php } ?>
                            </span>
                            <input id="relater" name="relater" class="form-control col-md-7" type="text">

                            {{--<input id="relater" class="form-control col-md-7" type="text" value = {{$request->relater}} placeholder={{$request->relater}}>--}}

                        </div>
                    </div>


                    <div class="col-md-12">
                        <label class="h4 col-offset-2">NỘI DUNG</label>
                    </div>
                    <div class="col-md-12">
                        <span>{{ $request->content }}</span>
                    </div>
                        <div class="btn-toolbar col-md-3 pull-right">
                        <button type="button" class="btn-primary" style="margin-top: 5px" id="save">save</button>
                        <button type="button" class="btn-primary " style="margin-top: 5px" id="cancel" >cancel</button>
                        </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel panel-body col-md-12">
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
        $(document).ready(function () {
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
        });

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
                        term: request.term
                    }, response );
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function( event, ui ) {
                    var terms = this.value.split(/,\s*/);
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


        function edit(id){
            $(id).prev().hide();
            $(id).show();
            $('#save').show();
            $('#cancel').show();

        };
        function cancel(){
            // an phan chinh sua
            if ($('#priority').is(":visible")){
                $('#priority').val($('#priority').prev().val());
                $('#priority').hide();
                $('#priority').prev().show();
            }

            if ($('#deadline').is(":visible")){
                $('#deadline').val($('#deadline').prev().val());
                $('#deadline').hide();
                $('#deadline').prev().show();
            }

            if ($('#team').is(":visible")){
                $('#team').val($('#team').prev().val());
                $('#team').hide();
                $('#team').prev().show();
            }

            if ($('#assigned_to').is(":visible")){
                $('#assigned_to').val($('#assigned_to').prev().val());
                $('#assigned_to').hide();
                $('#assigned_to').prev().show();
            }

            if ($('#relater').is(":visible")){
                $('#relater').val($('#relater').prev().val());
                $('#relater').hide();
                $('#relater').prev().show();
            }

            if ($('#status').is(":visible")){
                $('#status').val($('#status').prev().val());
                $('#status').hide();
                $('#status').prev().show();
            }

            $('#save').hide();
            $('#cancel').hide();
        }
        function save(){
            if(confirm("Bạn có thực sự muốn lưu không?")){
                $('#editForm').submit();
            }
        }
        function comment(){
            $('#comment').submit();
        }
    </script>
@endsection