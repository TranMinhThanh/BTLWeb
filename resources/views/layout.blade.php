@extends('layouts.app')

@section('head')
    <title> @yield('title')</title>

    <link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
    <style type="text/css">
        .panel{
            margin-bottom: 10px;
        }
        .panel-body{
            padding: 5px;
            border: 1px solid transparent;
        }
        .panel-heading{
            padding: 5px;
        }
        #creatRequest{
            margin: 15px;
            background-color: #23527c;
            color: #FFFFFF;
            margin-top: 0px;
        }
        #creatRequest:hover{
            color: deeppink;

        }
        .glyphicon{
            padding: 5px;
        }
        #content{
            margin: 1%;
        }
    </style>
    <script type="text/javascript" src="{{asset("js/bootstrap.min.js")}}"></script>
    @yield('child_head')

@endsection

@section('content')
<div class ="container-fluid" style="background-color:#98cbe8 ">
        <div class ='col-sm-2' id= 'menu' style="background-color:#98cbe8 ">
           <!-- <div class="panel-title">Request IT</div>-->
            <div class="row"><button class ='btn col-sm-offset-1' id="creatRequest">+ THÊM YÊU CẦU</button></div>

            <div class="panel panel-default">
                <div id = "menuHeadingRequire" class="panel-heading" data-toggle="collapse" data-target ="#menuRequire" onclick="open_close('#menuHeadingRequire')">
                    <label>Việc tôi yêu cầu</label>
                    <span  class ="pull-right glyphicon glyphicon-minus"></span>
                </div>

                <div class="panel-collapse collapse in" id = "menuRequire">
                    <div class="panel-body " id ="allRequire" onclick = "display()">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        <a>All</a>
                    </div>
                    <div class="panel-body" id ="newRequire" onclick="">
                        <span class = "glyphicon glyphicon-envelope"></span>
                        <span>New</span>
                    </div>
                    <div class="panel-body" id="inprogressRequest">
                        <span class=" glyphicon glyphicon-import"></span>
                        <span>Inprogress</span>
                    </div>
                    <div class="panel-body" id ="resolvedRequire">
                        <span class=" glyphicon glyphicon-registration-mark"></span>
                        <span>Resolved</span>
                    </div>
                    <div class="panel-body" id="OutOfDateRequire">
                        <span class=" glyphicon glyphicon-calendar"></span>
                        <span>Out Of Date</span>
                    </div>
                </div>

            </div>
            <!-- relatedWork : cong viec lien quan -->
            <div class="panel panel-default">
                <div id = "menuHeadingRelated" class="panel-heading" data-toggle="collapse" data-target ="#menuRelated" onclick="open_close('#menuHeadingRelated')">
                    <label>Công việc liên quan</label>
                    <span  class ="pull-right glyphicon glyphicon-minus"></span>
                </div>
                <div class="panel-collapse collapse in" id = "menuRelated">
                    <div class="panel-body" id ="allRelated" onclick = "display()">
                        <span class=" glyphicon glyphicon-list-alt"></span>
                        <span>All</span>
                    </div>
                    <div class="panel-body" id ="newRelated" onclick="">
                        <span class = "glyphicon glyphicon-envelope"></span>
                        <span>New</span>
                    </div>
                    <div class="panel-body" id="inprogressRelated">
                        <span class=" glyphicon glyphicon-import"></span>
                        <span>Inprogress</span>
                    </div>
                    <div class="panel-body" id ="resolvedRelated">
                        <span class=" glyphicon glyphicon-registration-mark"></span>
                        <span>Resolved</span>
                    </div>
                    <div class="panel-body" id="OutOfDateRelated">
                        <span class=" glyphicon glyphicon-calendar"></span>
                        <span>Out Of Date</span>
                    </div>
                </div>
            </div>
            @if((Auth::user()->level == 0) || (Auth::user()->level == 1) || (Auth::user()->level == 2))
            <!-- công việc tôi được giao-->
            <div class="panel panel-default">
                <div id = "menuHeadingAssigned" class="panel-heading" data-toggle="collapse" data-target ="#menuAssigned" onclick="open_close('#menuHeadingAssigned')">
                    <label>Công việc được giao</label>
                    <span  class ="pull-right glyphicon glyphicon-plus"></span>
                </div>
                <div class="panel-collapse collapse" id = "menuAssigned">
                    <div class="panel-body" id ="allAssigned" onclick = "display()">
                        <span class=" glyphicon glyphicon-list-alt"></span>
                        <span>All</span>
                    </div>
                    <div class="panel-body" id ="newAssigned" onclick="">
                        <span class = "glyphicon glyphicon-envelope"></span>
                        <span>New</span>
                    </div>
                    <div class="panel-body" id="inprogressAssigned">
                        <span class=" glyphicon glyphicon-import"></span>
                        <span>Inprogress</span>
                    </div>
                    <div class="panel-body" id ="resolvedAssigned">
                        <span class=" glyphicon glyphicon-registration-mark"></span>
                        <span>Resolved</span>
                    </div>
                    <div class="panel-body" id="OutOfDateAssigned">
                        <span class=" glyphicon glyphicon-calendar"></span>
                        <span>Out Of Date</span>
                    </div>
                </div>
            </div>
            @endif
            @if(Auth::user()->level == 1)
                <div class="panel panel-default">
                    <div id = "menuHeadingTeam" class="panel-heading" data-toggle="collapse" data-target ="#menuTeam" onclick="open_close('#menuHeadingTeam')">
                        <label>Công việc của team</label>
                        <span  class ="pull-right glyphicon glyphicon-plus"></span>
                    </div>
                    <div class="panel-collapse collapse" id = "menuTeam">
                        <div class="panel-body" id ="allTeam" onclick = "display()">
                            <span class=" glyphicon glyphicon-list-alt"></span>
                            <span>All</span>
                        </div>
                        <div class="panel-body" id ="newTeam" onclick="">
                            <span class = "glyphicon glyphicon-envelope"></span>
                            <span>New</span>
                        </div>
                        <div class="panel-body" id="inprogressTeam">
                            <span class=" glyphicon glyphicon-import"></span>
                            <span>Inprogress</span>
                        </div>
                        <div class="panel-body" id ="resolvedTeam">
                            <span class=" glyphicon glyphicon-registration-mark"></span>
                            <span>Resolved</span>
                        </div>
                        <div class="panel-body" id="OutOfDateTeam">
                            <span class=" glyphicon glyphicon-calendar"></span>
                            <span>Out Of Date</span>
                        </div>
                    </div>
                </div>
            @endif
            @if(Auth::user()->level == 0)
                <div class="panel panel-default">
                    <div id = "menuHeadingIT" class="panel-heading" data-toggle="collapse" data-target ="#menuIT" onclick="open_close('#menuHeadingIT')">
                        <label>Công việc bộ phận IT</label>
                        <span  class ="pull-right glyphicon glyphicon-plus"></span>
                    </div>
                    <div class="panel-collapse collapse" id = "menuIT">
                        <div class="panel-body" id ="allIT" onclick = "display()">
                            <span class=" glyphicon glyphicon-list-alt"></span>
                            <span>All</span>
                        </div>
                        <div class="panel-body" id ="newIT" onclick="">
                            <span class = "glyphicon glyphicon-envelope"></span>
                            <span>New</span>
                        </div>
                        <div class="panel-body" id="inprogressIT">
                            <span class=" glyphicon glyphicon-import"></span>
                            <span>Inprogress</span>
                        </div>
                        <div class="panel-body" id ="resolvedIT">
                            <span class=" glyphicon glyphicon-registration-mark"></span>
                            <span>Resolved</span>
                        </div>
                        <div class="panel-body" id="OutOfDateIT">
                            <span class=" glyphicon glyphicon-calendar"></span>
                            <span>Out Of Date</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-sm-10">
                {{--@include('createRequest');--}}
                @yield('child_content');
        </div>
</div>
<script type="text/javascript">
    function display() {

    }
    function open_close(id){
        var imgChild = $(id).children("span");
        var str = imgChild.attr("class");
        if(str.search("glyphicon-minus") != -1){
            str = str.replace('glyphicon-minus','glyphicon-plus');
            // document.write(str);
            imgChild.attr("class",str);
        }
        else{
            str = str.replace('glyphicon-plus','glyphicon-minus');
            imgChild.attr("class",str);
        }
    }
</script>
@endsection