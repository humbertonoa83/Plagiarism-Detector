<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Maintaining</title>
    <link rel="stylesheet" type="text/css" href="{{asset('dist/sstyle.css')}}" />

    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js'></script>
    <link rel='stylesheet'  href='https://mdbootstrap.com/wp-content/themes/mdbootstrap4/css/compiled-4.17.0.min.css?ver=4.17.0'/>
    <script type='text/javascript'>




        $(function() {
            $('#tipsy').tipsy({fade: true, gravity: 's'});
        });
    </script>



    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
<div class="wrapper">
    <img class="logo" src="" alt="YouSeoTools" title="Logo"/>
    <div class="hr"></div>
    <h1>Sorry, we are undergoing maintenance.</h1>
    <p>It's quick, we are running some security procedures so that your data is not lost.</p>



    <script>
        start_date = new Date();
        end_date = new Date();
        var start = start_date.getTime();
        var end = end_date.getTime();



        window.setInterval(function(){
            var now = +new Date;
            restante= end - start;
            porcentagem =  ( now - start ) / ( end - start ) * 100; //73%
            if (porcentagem > 100) {
                porcentagem = "100";
            }

            if (porcentagem === 100 ) {
                location.reload();
            }


            document.getElementById('tipsy').setAttribute('title',Math.round(porcentagem) + "% Complete.");
            porcentagem = porcentagem + "%";

            document.getElementById("progress-bar").style.width=porcentagem;



        }, 100);
    </script>
    <section class="progress">
        <div class="progress-bar-container" id="tipsy" title="60% Complete"> <!-- Edit this title for the tooltip pop up -->
            <article id="progress-bar" class="progress-bar"   ></article> <!-- Edit the width percentage value to indicate progress -->

        </div>

    </section>



</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
