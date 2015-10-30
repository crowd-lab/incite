<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mapping the 4th Static Page</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Browse Collections</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="transcribe.html">Transcribe</a>
                    </li>
                    <li>
                        <a href="tag.html">Tag</a>
                    </li>
                    <li>
                        <a href="discuss.html">Discuss</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="second header">
            <!-- Primary Navbar -->
            <div class="navbar navbar-inverse" style="margin-right:-40px;">
              <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">Document name</a>
                </div>
                <div class="nav navbar-nav navbar-right"> 
                    <ul class="nav navbar-nav">
                        <li ><a href="transcription_document.html">Transcribe</a></li>
                        <li class="active"><a href="#about">Tag</a></li>
                        <li><a href="#contact">Menu Item 2</a></li>
                        <li><a href="#about">Menu Item 3</a></li>
                    </ul>
                </div> 
              </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="60"
                    aria-valuemin="0" aria-valuemax="100" style="width:60%">
                    60%
                </div>
            </div>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-default">Subscribe</button>
                <button type="button" class="btn btn-default">Guide</button>
            </div>
        </div>
        <div class="container">
            <div class="col-md-8">
                <textarea name="transcribe_text" cols="97" rows="40" id="transcribe_copy">Transcription</textarea>
                <img id="document_img" src="copy.jpg" alt="Mountain View" style="width:604px;height:800px;">
                <br>
                <button type="button" class="btn btn-default" id="show">Document</button>
                <button type="button" class="btn btn-default" id="hide">Transcription</button>
            </div>
            <div class="col-md-4">
                <h2>Title of Discussion:
                    How do Northerners vs. Southerners write about George Washington?</h2>

                <h4>
                    Content: 
                </h4>
                <br>
                <p>
                    (User1): While I was reading this diary, I feel people in the South seem to think of Washington as…
                </p>
                <p>Is this related?</p>
                <button type="button" class="btn btn-default" id="">Yes</button>
                <button type="button" class="btn btn-default" id="">No</button>
                <br>

                <textarea name="transcribe_text" cols="60" rows="10" id="transcribe_copy">Your Response</textarea>
                <button type="button" class="btn btn-default" id="">Submit</button>


            </div>
      

    </div>
            </div> 
        </div>




  
</div>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({ trigger: "hover" });
        $("#transcribe_copy").hide();
    $("#hide").click(function(){
        $("#document_img").hide();
        $("#transcribe_copy").show();
    });
    $("#show").click(function(){
        $("#document_img").show();
        $("#transcribe_copy").hide();
    });
});
</script>

</body>

</html>