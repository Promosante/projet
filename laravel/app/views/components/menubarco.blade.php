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
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Mon compte
                            <b class="caret"></b>
                            @if(Notif::get_nb_new_notifs()>0)
                                <span class="badge pull-right btn-danger" style="background-color:red;margin-left:10px;font-size:17px;margin-top:-4px">{{Notif::get_nb_new_notifs()}}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                             <li>
                                <a href="{{ URL::to( 'notifications') }}">
                                  Evenements
                                    @if(Notif::get_nb_new_notifs()>0)
                                        <span class="badge" style="background-color:red;margin-left:20px;">{{Notif::get_nb_new_notifs()}}</span>
                                    @endif
                                </a>

                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ URL::to( 'profil') }}">
                                   Visualiser mon profil
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL::to( 'editprofil') }}">
                                    Modifier mon profil
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ URL::to( 'logout') }}">
                                    Log out
                                </a>
                            </li>
        
                        </ul>
                    </li>
                    <li class="{{ Request::is( 'my-projects*')  }}"><a href="{{ URL::to( 'my-projects') }}">Mes projets</a></li>
                    <li>
                        <a href="{{ URL::to( 'messagerie-br') }}">
                            Messagerie
                        </a>
                    </li>
                    <li><a href="{{ URL::to( 'recherche') }}">Recherche</a></li>  
                    <li><a href="{{ URL::to( 'contact-us') }}">Nous contacter</a></li> 
                    </ul>

                     <ul class="nav navbar-nav pull-right">
                       <li>
                            <a href="{{ URL::to( 'logout') }}">
                                Log out
                            </a>
                        </li>
                     </ul>
                     @if( count( DB::table('administrateurs')->where('compte_id','=',Auth::user()->id)->get() ) > 0 )
                     <ul class="nav navbar-nav pull-right">
                       <li>
                            <a href="{{ URL::to('admin') }}">
                                Administration
                            </a>
                        </li>
                     </ul>
                    @endif 
                </div>
    </div>
</div>