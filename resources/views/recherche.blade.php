<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>@yield('title', 'Admin - '.Voyager::setting("admin.title"))</title>
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    @if (__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif
    <style>
        body {
            background-color: {{ Voyager::setting("admin.bg_color", "#FFFFFF" ) }};
        }
        body.login .login-sidebar {
            border-top:5px solid {{ config('voyager.primary_color','#22A7F0') }};
        }
        @media (max-width: 767px) {
            body.login .login-sidebar {
                border-top:0px !important;
                border-left:5px solid {{ config('voyager.primary_color','#22A7F0') }};
            }
        }
        body.login .form-group-default.focused{
            border-color:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .login-button, .bar:before, .bar:after{
            background:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .remember-me-text{
            padding:0 5px;
        }
    </style>
    
    @yield('pre_css')
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body class="login">
<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="hamburger btn-link">
                <span class="hamburger-inner"></span>
            </button>
            @section('breadcrumbs')
            <ol class="breadcrumb hidden-xs">
                @php
                $segments = array_filter(explode('/', str_replace(route('voyager.dashboard'), '', Request::url())));
                $url = route('voyager.dashboard');
                @endphp
                @if(count($segments) == 0)
                    <li class="active"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</li>
                @else
                    <li class="active">
                        <a href="http://localhost:8000/admin"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</a>
                    </li>
                    @foreach ($segments as $segment)
                        @php
                        $url .= '/'.$segment;
                        @endphp
                        @if ($loop->last)
                            <li>{{ ucfirst(urldecode($segment)) }}</li>
                        @else
                            <li>
                                <a href="{{ $url }}">{{ ucfirst(urldecode($segment)) }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ol>
            @show
        </div>
        
    </div>
</nav>

<br>
<br>
<br>
<br>

<div class="container-fluid">
    <div class="row">
        
        
        

        <div class="col-xs-12 col-sm-7 col-md-6 ">
        <?php
        class Connexion {
    private $connexion;

    public function __construct() {
        $host = 'localhost:3307';
        $dbname = 'school2';
        $login = 'root';
        $password = '';
        try {
            $this->connexion = new PDO("mysql:host=$host;dbname=$dbname", $login, $password);
            $this->connexion->query("SET NAMES UTF8");
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    function getConnexion() {
        return $this->connexion;
    }

}
?>
            <form method='GET'>
                
                <input  name="recherche_valeur">              

                <input type='submit' class="btn btn-primary" value="Rechercher"/>
            </form>
            
            <div class="row justify-content-center">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" border="1">
                <thead>
                    <tr><th>Id</th><th>Classe</th><th>filiere</th>
                </thead>
                <tbody>
                    <?php
                    $connect = new Connexion();
$sql = 'select classses.id, classses.code, classses.id_filiere from classses inner join filieres on classses.id_filiere=Filieres.code ';
                    $params = [];
                    if (isset($_GET['recherche_valeur'])) {
                        $sql .= ' where classses.id_filiere like :id_filiere;';
                        $params[':id_filiere'] = "%" . addcslashes($_GET['recherche_valeur'], '_') . "%";
                    }
    
                    $resultats = $connect->getConnexion()->prepare($sql);
                    $resultats->execute($params);
                    if ($resultats->rowCount() > 0) {
                        while ($d = $resultats->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr><td><?= $d['id'] ?></td><td><?= $d['code'] ?></td><td><?= $d['id_filiere'] ?></td></tr>
                            <?php
                        }
                        $resultats->closeCursor();
                    } else {
                        echo '<tr><td colspan=4>aucun résultat trouvé</td></tr>' .
                        $connect = null;
                    }
                    ?>
                </tbody>
            </table>



        </div> <!-- .login-sidebar -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->
@yield('post_js')
</body>
<script src="../dist/jquery-3.6.0.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="../dist/chart.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>
</html>
