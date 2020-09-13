<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>

    <link rel='stylesheet'  href='https://mdbootstrap.com/wp-content/themes/mdbootstrap4/css/compiled-4.17.0.min.css?ver=4.17.0'/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('public/dist/style5.css')}}">
    <link rel="stylesheet" href="{{asset('public/dist/main.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">


    <link rel="stylesheet" href="{{asset('public/dist/node_modules/fontawesome-free/css/all.min.css')}}">

    <style>
        .loader {
            position: fixed;
            z-index: 99;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        u.yell{
            text-decoration: #ffdf12 underline;
        }

        u.redd{
            text-decoration: #ff3f14 underline;
        }

        .loader > img {
            width: 100px;
        }

        .loader.hidden {
            animation: fadeOut 1s;
            animation-fill-mode: forwards;
        }

        @keyframes fadeOut {
            100% {
                opacity: 0;
                visibility: hidden;
            }
        }

    </style>

</head>
<body style="background-color: #f4f8fa">
<!--<div class="loader">
    <img src="media/img/loading.gif" alt="Loading..." />
</div>
-->
<div class="wrapper">
    <nav id ="sidebar">
        <div class="sidebar-header">
            <h3>Youseotools</h3>

        </div>
        <!-- Sidebar Links -->
        <ul class="list-unstyled components">
            <p>Plagiarism Checker</p>
        </ul>
    </nav>

    <div id="content">


        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <div class="navbar-header" >

                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">

                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="align-items-center">
                <div id="doc-textarea" style="display: block">
                    @if($try ==false)
                        @foreach($resultPercentage as $key=> $percentage)
                            @if($percentage>=50 && $percentage<90)
                                <u class="yell"><span title='{{$count++}} - {{$percentage}} %'>{{$key}}.</span></u>
                            @elseif($percentage>=90)
                                <u class="redd"><span title='{{$count++}} - {{$percentage}} % '>{{$key}}.</span></u>
                            @else
                                <span title='{{$count++}} - {{$percentage}} %'>{{$key}}.</span>
                            @endif

                        @endforeach
                        <hr>
                        @if($totalpercentage>=50)
                            <div style="font-family: Quicksand,serif; font-weight: 100;"><h2>Plagiarism Percentage: {{round($totalpercentage)}}<span >%</span> -       Unique:  {{100 - round($totalpercentage,0)}} <span>%</span></h2></div>
                            @foreach ($resultLinks as $key=> $value)
                            <!--
							 * The link come like https://Something.com/else/none/9320
							 * or http://Something.com/else/none/9320
							 * I'm removing the http:// and https:// and replacing / to >
							 * and the final product it'll be
							 * Something.com > else > none > 9320
							-->
                                <p style="color:  #335deb"><a href="{{$key}}"><b>{{$value}}</b></a></p>
                            @endforeach
                        @else
                            <div style="font-family: Quicksand,serif; font-weight: 100;"><h2>Unique</h2></div>
                        @endif
                    @else
                        <p>Try Again Later</p>
                    @endif
                </div>
                <a href="{{route('index')}}" class="btn btn-primary"><i class="fas fa-search">Check</i></a>
            </div>
        </div>
    </div>

</div>




<!-- Footer -->
<footer class="modal-footer">
    <p>Created by <b>Humberto Pfumo © 2020</b></p>
    <p>Contact information: <a href="mailto:humbertonoa83@gmail.com?Subject=Help%can%you%help!">humbertonoa83@gmail.com</a>.</p>
</footer >

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
    //window.addEventListener("load", function () {
    //  const loader = document.querySelector(".loader");
    //loader.className += " hidden"; // class "loader hidden"
    //});

    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });

    });

</script>
</body>
</html>
