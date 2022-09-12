<nav class="navbar navbar-default" id="mainNav">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="logo">
            <a class="navbar-brand js-scroll-trigger logo-header" href="#">
                <img src="{{ asset('landing-assets/images/logo-pink.png') }}" alt="">
            </a>
        </div>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#banner">Home</a></li>
            <li><a href="#about">About us</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#our_team">Team</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#feedbacks">Feedback</a></li>
            <li><a href="#pricing">Pricing</a></li>
            {{-- <li><a href="#reservation">Reservation</a></li> --}}
            <li><a href="#footer">Contact us</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
        </ul>
    </div>
    <!-- end nav-collapse -->
</nav>