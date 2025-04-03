<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gerenciamento de Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }
        .card {
            margin-bottom: 20px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .filter-form {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .money {
            text-align: right;
            white-space: nowrap;
        }
        .actions-column {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://via.placeholder.com/30" alt="Logo">
                Sistema Clientes
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="import.php">Importar CSV</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="list.php">Listar Clientes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php 
        $page = isset($_GET['page']) ? $_GET['page'] : 'import';
        switch($page) {
            case 'list':
                include 'backend/list.php';
                break;
            case 'edit':
                include 'backend/edit.php';
                break;
            default:
                include 'backend/import.php';
        }
        ?>
    </div>

    <footer class="mt-5 py-3 bg-light">
        <div class="container text-center">
            <p class="mb-0">Sistema de Gerenciamento de Clientes &copy; <?= date('Y') ?></p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        // Máscaras para os campos
        $(document).ready(function(){
            $('.cpf-mask').mask('000.000.000-00');
            $('.phone-mask').mask('(00) 00000-0000');
            $('.money-mask').mask('000.000.000.000.000,00', {reverse: true});
            $('.date-mask').mask('00/00/0000');
        });
    </script>
</body>
</html>