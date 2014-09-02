<div class="row">
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">NomDuSite</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav pull-left">
                        <li class="{{ Request::is( 'home') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'home') }}">
                            Home
                            </a>
                        </li>
                    
                     <li><a href="#">Nous contacter</a></li> 
                    </ul>
                     <ul class="nav navbar-nav pull-right">
                       <li class="{{ Request::is( 'login') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'login') }}">
                            Login
                            </a>
                        </li>
                        <li class="{{ Request::is( 'signup') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'signup') }}">
                            Sign up
                            </a>
                        </li>
                     </ul>
                </div>
    </div>
</div>