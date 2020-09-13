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
    <link rel="stylesheet" href="{{asset('dist/style5.css')}}">

    <link rel="stylesheet" href="{{asset('dist/main.min.css')}}">
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
        <!--<div class="jumbotron text-center">
            <h3>Plagiarism Checker</h3>
        </div> -->
        <div class="container">

            <form action="{{route('plagium.submit')}}" method="post" onsubmit="return validateForm()" class="form-group ">
                @csrf
                <div class="align-items-center">
                    <textarea id="text" rows="20" class="form-control" name="text" placeholder="Write any Thing"></textarea>
                </div>
                <br>
                <span id="words-count"></span><br><br>


                <!--<div class="file-field container">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Or Upload
                    <a class="btn-floating purple-gradient mt-0 float-none">
                        <i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>
                        <input type="file" name="fileToUpload">
                    </a>
                </div> -->


                <button type="submit" class="btn btn-primary" id="verify">Verify</button>

            </form>
        </div>
    </div>



</div>
<footer class="modal-footer">
    <p>Created by <b>Humberto Pfumo © 2020</b></p>

</footer >
<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Bootstrap -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Our helper-->
<script src="{{asset('dist/js/helper.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });

        $('#verify').on('click', function () {
            <!-- document.getElementById("load").style.visibility = "visible"; -->

            $('#load').style.visibility = "visible";
        })
    });
</script>

</body>
</html>
