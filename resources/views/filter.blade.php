@extends('layout')
@section('child_content')
    <div class="panel panel-default" style="margin-top: 5%">
        <div class="panel panel-heading">
            <label class="h4 col-md-10">{{$title}}</label>
            <div class="btn-toolbar ">
            <button type="button" class="btn btn-primary  " title="Reset bộ lọc"><span class="glyphicon glyphicon-refresh"></span></button>
            <button type="button" class="btn btn-primary " title="Tìm kiếm"><span class="glyphicon glyphicon-search"></span></button>
            </div>
            </div>
        <div class="panel panel-body">
            <table class="table">
                <thead>
                    <tr><th col-md-1>STT</th>
                        <th col-md-5>Tên công việc</th>
                        <th col-md-2>Mức độ ưu tiên</th>
                        <th>Người yêu cầu</th>
                        <th>Người thực hiện</th>
                        <th>Bộ phận IT</th>
                        <th>Ngày hết hạn</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
            <
        </div>
    </div>
@endsection