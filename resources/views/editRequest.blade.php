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
                <label class="h4 col-md-7"><span class="glyphicon glyphicon-globe"></span>Test</label>
                <div class="btn-toolbar">
                    <button type="button" class=" btn btn-default " title="Thay đổi bộ phận IT" ><span class="glyphicon glyphicon glyphicon-cd small "></span></button>
                    <button type="button" class=" btn btn-default "title="Thay đổi mức độ ưu tiên"><span class="glyphicon glyphicon-retweet small"></span></button>
                    <button type="button" class=" btn btn-default " title="Thay đổi deadline"><span class="glyphicon glyphicon-calendar small"></span></button>
                    <button type="button" class=" btn btn-default "title="Assign"><span class="glyphicon glyphicon-hand-right small"></span></button>
                    <button type="button" class=" btn btn-default "title="Thay đổi người liên quan"><span class="glyphicon glyphicon-user small"></span></button>

                    <button type="button" class=" btn btn-default" title="Thay đổi trạng thái"><span class="glyphicon glyphicon-transfer"></span></button>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="row">
                        <label class="col-md-5">Ngày tạo:</label>
                        <span class="col-md-7"> 22/12/2222</span>
                    </div>
                    <div class="row">
                        <label class="col-md-5">Người yêu cầu:</label>
                        <span class="col-md-7"> Pham Tuấn Anh</span>
                    </div>
                    <div class="row">
                        <label class="col-md-5">Mức độ ưu tiên</label>
                        <span class="col-md-7">Bình thường</span>
                    </div>
                    <div class="row">
                        <label class="col-md-5">Bộ phận IT</label>
                        <span class="col-md-7">IT-Hà nội</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <label class="col-md-5">Ngày hết hạn:</label>
                        <span class="col-md-7"> 22/12/2222</span>
                    </div>
                    <div class="row">
                        <label class="col-md-5">Người thực hiện:</label>
                        <span class="col-md-7"> Pham Tuấn Anh</span>
                    </div>
                    <div class="row">
                        <label class="col-md-5">Trạng thái</label>
                        <span class="col-md-7">New</span>
                    </div>
                    <div class="row">
                        <label class="col-md-5">Người liên quan</label>
                        <span class="col-md-7">Bình thường</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <label class="h4 col-offset-2"><span class="glyphicon glyphicon-file"></span>Noi dung</label>
            </div>
            <div class="panel panel-body col-md-12">
                //binh luan
            </div>
            <div class=" panel panel-body">
                <div ><label class="control-label h4"><span class="glyphicon glyphicon-edit"></span>Binh luan</label></div>
                <div>
                    <ul class="nav nav-pills">
                        <li ><a>Bold</a></li>
                        <li><a >Italic</a></li>
                        <li><a>Messages</a></li>
                    </ul>
                </div>
                <div >
                    <textarea type="text" class="form-control" id="requestContent" rows = '10' ></textarea>
                </div>
                <button class="btn btn-primary">Bình luận</button>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection