     <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="../index.php"><img src="../images/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="../images/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="../index.php"> <i class="menu-icon fa fa-dashboard"></i>Почетна страна </a>
                    </li>
                    
                    <h3 class="menu-title">Администрација</h3><!-- /.menu-title -->
                    <li>
                        <a href="novi_suosnivac.php"> <i class="menu-icon fa fa-user-o"></i>Унос новог суоснивача</a>
                    </li>
                     <li>
                        <a href="suosnivaci_izmena.php"><i class="menu-icon fa fa-id-card-o"></i> Измена података</a>
                     </li>
                     <!-- <li><a href="ovlasceni_izmena.php"><i class="menu-icon fa fa-user-secret"></i> Промена овлашћења</a>
                     </li> -->
                      <li><a href="datum_uplate_izmena.php"><i class="menu-icon fa fa-calendar"></i> Измена и брисање датума уплате</a>
                     </li>
                     <h3 class="menu-title">Предрачуни и рачуни</h3>
                     <li><a href="iskljuci_notifikacije.php"><i class="menu-icon fa fa-user-times"></i> Искључивање слања<br>предрачуна</a>
                     </li>
                     <li><a href="brisanje_predracuna_racuna.php"><i class="menu-icon fa fa-list"></i> Брисање предрачуна и рачуна</a>
                     </li>
                     <li><a href="promeni_iznos_clanarine.php"><i class="menu-icon fa fa-money"></i> Промена износа<br>годишње накнаде</a>
                     </li>
                     <li><a href="promeni_direktora.php"><i class="menu-icon fa fa-user-times"></i> Смена директора :)</a>
                     </li>
                     <h3 class="menu-title">Конференције</h3><!-- /.menu-title -->
                     <li><a href="konferencija_izmena.php"><i class="menu-icon fa fa-pencil"></i> Измена података о конференцији</a>
                     </li>
                     <li><a href="obrisi_listu_pravo_glasa.php"><i class="menu-icon fa fa-list"></i> Брисање листе са правом гласа</a>
                     </li>
                     
                     
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
              <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>      
<!--                     
<div class="header-left">
    <button class="search-trigger"><i class="fa fa-search"></i></button>
    <div class="form-inline">
        <form class="search-form">
            <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
            <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
        </form>
    </div>

    <div class="dropdown for-notification">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell"></i>
        <span class="count bg-danger">5</span>
      </button>
      <div class="dropdown-menu" aria-labelledby="notification">
        <p class="red">Имате нову поруку</p>
        <a class="dropdown-item media bg-flat-color-1" href="#">
            <i class="fa fa-check"></i>
            <p>Нека порука...бла.</p>
        </a>
        <a class="dropdown-item media bg-flat-color-4" href="#">
            <i class="fa fa-info"></i>
            <p>Server #2 overloaded.</p>
        </a>
        <a class="dropdown-item media bg-flat-color-5" href="#">
            <i class="fa fa-warning"></i>
            <p>Server #3 overloaded.</p>
        </a>
      </div>
    </div>

    <div class="dropdown for-message">
      <button class="btn btn-secondary dropdown-toggle" type="button"
            id="message"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="ti-email"></i>
        <span class="count bg-primary">9</span>
      </button>
      <div class="dropdown-menu" aria-labelledby="message">
        <p class="red">Имате 4 емаил-а</p>
        <a class="dropdown-item media bg-flat-color-1" href="#">
            <span class="photo media-left"><img alt="avatar" src=""></span>
            <span class="message media-body">
                <span class="name float-left">Бојана Живковић</span>
                <span class="time float-right">Управо</span>
                    <p>Ово је порука...блабла</p>
            </span>
        </a>
        <a class="dropdown-item media bg-flat-color-4" href="#">
            <span class="photo media-left"><img alt="avatar" src=""></span>
            <span class="message media-body">
                <span class="name float-left">Jack Sanders</span>
                <span class="time float-right">5 minutes ago</span>
                    <p>Lorem ipsum dolor sit amet, consectetur</p>
            </span>
        </a>
        <a class="dropdown-item media bg-flat-color-5" href="#">
            <span class="photo media-left"><img alt="avatar" src="images/avatar/3.jpg"></span>
            <span class="message media-body">
                <span class="name float-left">Cheryl Wheeler</span>
                <span class="time float-right">10 minutes ago</span>
                    <p>Hello, this is an example msg</p>
            </span>
        </a>
        <a class="dropdown-item media bg-flat-color-3" href="#">
            <span class="photo media-left"><img alt="avatar" src=""></span>
            <span class="message media-body">
                <span class="name float-left">Мирјана М.</span>
                <span class="time float-right">Пре 15 минута</span>
                    <p>бла, бла, бла..</p>
            </span>
        </a>
      </div>
    </div>
</div> -->
                </div>
        

                 <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a class="nav-link" href="../index.php"><i class="fa fa- user"></i>КОРИСНИЧКИ ДЕО</a>
                    </div>
                </div>
                <!-- <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/logo.png" alt="RNIDS">
                        </a>
                
                        <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>
                
                                <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a>
                
                                <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>
                
                                <a class="nav-link" href="#"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>
                
                    <div class="language-select dropdown" id="language-select">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown"  id="language" aria-haspopup="true" aria-expanded="true">
                            <i class="flag-icon flag-icon-us"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="language" >
                            <div class="dropdown-item">
                                <span class="flag-icon flag-icon-fr"></span>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-es"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-us"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-it"></i>
                            </div>
                        </div>
                    </div>
                
                </div> -->
            </div>
        </header><!-- /header -->
         <!-- Header-->

       