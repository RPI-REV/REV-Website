<!DOCTYPE html>
<html>

<head>
    <meta charset="uft-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REV - Home</title>
    <link rel="stylesheet" href="/assets/base.css">
    <link rel="stylesheet" href="/assets/home.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <script src="/assets/scroll.js"></script>
    <script src="/assets/facebook.js"></script>
    <script src="/assets/konami.js"></script>
</head>

<body>
    <div class="navbar navbar-default navbar-fixed-top" id="nav">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://rev.union.rpi.edu/">
                <img src="/assets/img/logo.png" alt="REV" height="30" width="69">
            </a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav scroll-buttons">
                <li><a href="#">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#team">Our Team</a></li>
                <li><a href="#marketing">Marketing</a></li>
                <li><a href="#join">Join!</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="/sponsors.html">Sponsors</a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Team Links <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/">Main</a></li>
                        <li><a href="/cars.html">Cars</a></li>
                        <li class="divider"></li>
                        <li><a href="https://www.facebook.com/pages/Rensselaer-Electric-Vehicle-REV/115564911841565">Facebook</a></li>
                        <li><a href="https://www.flickr.com/photos/117673995@N07/">Flickr</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <br>
    <br>
    <div class="wrapper">
        <div class="carousel slide" id="pictures" data-ride="carousel">
            <ul class="carousel-indicators">
                <li class="active" data-target="#pictures" data-slide-to="0"></li>
                <li data-target="#pictures" data-slide-to="1"></li>
                <li data-target="#pictures" data-slide-to="2"></li>
                <li data-target="#pictures" data-slide-to="3"></li>
            </ul>
            <div class="carousel-inner">
                <div class="item active">
                    <center>
                        <img src="/assets/img/misc/team_picture.jpg" height="654" alt="Image " />
                    </center>
                    <div class="container ">
                        <div class="carousel-caption "></div>
                    </div>
                </div>
                <div class="item ">
                    <center>
                        <img src="/assets/img/misc/jamie.jpg" height="654" alt="Image" />
                    </center>
                    <div class="container">
                        <div class="carousel-caption"></div>
                    </div>
                </div>
                <div class="item ">
                    <center>
                        <img src="/assets/img/misc/tachyon_face.jpg" height="654" alt="Image " />
                    </center>
                    <div class="container ">
                        <div class="carousel-caption "></div>
                    </div>
                </div>
                <div class="item ">
                    <center>
                        <img src="/assets/img/misc/team_picture2.jpg" height="654" alt="Image" />
                    </center>
                    <div class="container">
                        <div class="carousel-caption"></div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#pictures" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#pictures" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>

        <section id="about">
            <div class="container">
                <h1>Rensselaer Electric Vehicle</h1>
                <p class="lead">We design and build electric cars from the ground up</p>
                <p>
                    Rensselaer Electric Vehicle (REV) is a student organization for the design of electric vehicles at Rensselaer Polytechnic Institute. The team, formerly known as the RPI Solar Car Racing Team, has competed in the Shell Eco-marathon since 2011. We have
                    built three cars since we were founded, and in 2014 we hope to compete in a new category, Urban Concept.
                </p>
            </div>
        </section>
        <section id="team">
            <div class="container">
                <h1>Our Team</h1>
                <p class="lead">Our two departments collaborate to create the best possible product</p>
                <div class="col-sm-6">
                    <p>
                        <b>The mechanical team</b> designs the body, chassis, and mechanical systems of our car. They use software such as Solidworks to aid with design, and to vusialize the final project. A lot a machining is done in-house, using RPI's
                        machine shops.
                    </p>
                </div>
                <div class="col-sm-6">
                    <p>
                        <b>The electrical team</b> creates systems to control the car. They use control hardware such as Arduinos and Rasperry Pi's. Software development in done with C, Python, and bash scripts. They use KiCAD for schematic and PCB design.
                    </p>
                </div>
            </div>
        </section>
        <section id="join">
            <div class="container">
                <h1>Join the Team!</h1>
                <p class="lead">We try to provide a welcoming and open environment</p>
                <p>
                    Our club has a strong focus on older members working with new members, and helping incoming students along. We provide opportunities for new students to get hands-on experiance quickly, as well as teach them basic design principles and practices. We meet
                    in Ricketts 212 Tuesdays from 7-8 and Saturdays from 12-3.
                </p>
            </div>
        </section>
        <div id="thisTeamisFantastic">
            <center>
                <h1>We're a pretty great club to join</h1>
                <div class="row" id="easter_egg">
                    <img src="/assets/img/misc/easter_egg.png" height="800" alt="Image" />
                </div>
            </center>
        </div>
        <div class="push "></div>
    </div>
    <div class="footer ">
        <div class="row ">
            <div class="col-md-3 ">
                <a href="mailto:rev@union.rpi.edu ">Contact Us! <br></a>
                <a href="http://www.union.rpi.edu ">Rensselaer Union <br></a>
                <a href="http://www.shell.com/global/environment-society/ecomarathon/events/americas.html ">Shell Eco-Marathon <br></a>
                <a href="/sponsors.html">Check out our sponsors!</a>
            </div>
            <div class="col-md-3 ">
                <a href="mailto:blejwp@rpi.edu ">Paul Blejwas - President <br></a>
                <a href="mailto:yehp@rpi.edu ">Phil Yeh - Project Manager <br></a>
                <a href="mailto:freitj2@rpi.edu ">Jamie Freitag - Vice President <br></a>
                <a href="mailto:delanr3@rpi.edu ">Ryan Delaney - Webmaster</a>
            </div>
            <div class="col-md-3 ">
                <div class="fb-like " data-href="https://www.facebook.com/pages/Rensselaer-Electric-Vehicle-REV/115564911841565 " data-layout="standard " data-action="like " data-show-faces="true " data-share="true " colorscheme="dark "></div>
            </div>
        </div>
    </div>
</body>

</html>
