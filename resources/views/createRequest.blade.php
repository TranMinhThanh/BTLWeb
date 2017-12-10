@extends('layout')

@section('child_head')
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href={{ asset('css/ajax/libs/jqueryui/jquery-ui.css') }}>
    <script src= {{ asset('js/ajax/libs/jquery/jquery.min.js') }}></script>
    <script src= {{ asset('js/ajax/libs/jqueryui/jquery-ui.min.js') }}></script>

@endsection

@section('child_content')
    <div id='contentRequest'>
        <div class ='row h4'><label class = "control-label" >Thêm yêu cầu</label></div>
        <div class="col-md-12">
            <form margin=3% method="post" id="requestForm" action="{{ route('createRequest') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for ='title' id="title" class="control-label">Tên công việc</label>
                        <input type="text" name="title" id ="title" class="form-control" placeholder="Tên công việc">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for ='priority' id="priority" class="control-label">Mức độ ưu tiên</label>
                        <select class="form-control" id="priority">
                            <option value="1">Thấp</option>
                            <option value="2">Bình thường</option>
                            <option value="3">Cao</option>
                            <option value="4">Khẩn cấp</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for ='deadline' id="deadline_label" class="control-label">Ngày hết hạn</label>
                        {{--<input type="text" name="name" id ="deadline" class="form-control">--}}
                        <input id="deadline" type= 'date' class="form-control" />

                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for ='nameOfWork' class="control-label">Bộ phận IT</label>
                        <select class="form-control" id="">
                            <option>IT-HaNoi</option>
                            <option>IT-DaNang</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for ='nameOfWork' class="control-label">Người liên quan</label>
                        <input type="text" name="name" id ="nameOfWork" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Nội dung</label>
                        <textarea font-family ='Time New Roman'></textarea>
                        <div class="btn-group">
                            <button type="button" class ="btn btn-default">Bold</button>
                            <button type="button" class ="btn btn-default" >Italic</button>
                            <button type="button" class ="btn btn-default">Bold</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default "><span class="glyphicon glyphicon-bold"></span> </button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default "><span class="glyphicon glyphicon-italic"></span> </button>
                        </div>
                        <textarea class="form-control" rows="5"></textarea>
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                        <button type="button" class="btn btn-primary">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#deadline").datepicker();
        });
    </script>
@endsection