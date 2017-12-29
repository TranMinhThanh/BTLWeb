{{--kieu thong bao tao request hay comment hay update--}}
<html>
    <?php if ($type == 1){ ?>
        Công việc {{$name}} đã được {{env('typeNotifi.'.$type)}} bởi {{$person}}
    <?php }
    else { ?>
        {{person}} đã {{env('typeNotifi.'.$type)}} công việc {{$name}}
    <?php } ?>
<br>
    Nội dung công việc: {{$content}}
{{--noi dung thong bao--}}

</html>
