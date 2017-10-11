<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"> मालक्ष्मी</a><!-- मा लक्ष्मी -->
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ url('/logout') }}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="">
                <a href="{{url('/')}}"><i class="fa fa-fw fa-dashboard"></i> ड्यासबोर्ड</a>
            </li>
            <li class="">
                <a href="{{ url('/customer') }}"><i class="fa fa-fw fa-common-admin"></i> ग्राहक </a>
            </li>
            <?php 
                if(Auth::user()->type == 1)
                {
                    ?>
                        <li class="">
                            <a href="{{ url('/units') }}"><i class="fa fa-fw fa-common-admin"></i> इकाइ(units)</a>
                        </li>
                        <li class="">
                            <a href="{{ url('/item') }}"><i class="fa fa-fw fa-common-admin"></i> समान  </a>
                        </li>
                        <!-- <li class="">
                            <a href="{{ url('/vehicles') }}"><i class="fa fa-fw fa-common-admin"></i> Vehicles </a>
                        </li> -->
                        <!-- <li class="">
                            <a href="{{ url('/staff') }}"><i class="fa fa-fw fa-common-admin"></i> Staff</a>
                        </li> -->
                    <?php
                }
            ?>
            
            
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#bill_link"><i class="fa fa-fw fa-arrows-v"></i> बिल <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="bill_link" class="collapse">
                    <li>
                        <a href="{{ url('/bill') }}"><i class="fa fa-fw fa-common-admin"></i> नया बिल</a>
                    </li>
                    <li>
                        <a href="{{ url('/bill-list') }}"><i class="fa fa-fw fa-common-admin"></i> बिल लिस्ट  </a>
                    </li>
                </ul>
            </li>
            
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>