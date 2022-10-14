<?php $_GET = ["getByUrl" => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"]; require "server/ProductService.php"; if ($data[0]['status'] == 0) die("ERROR - продукт неактивен") ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header class="d-flex justify-content-center py-3 mb-5">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link">Добавить товар</a></li>
            <li class="nav-item"><a href="/List" class="nav-link">Список товаров</a></li>
        </ul>
    </header>
    <div class="d-flex align-items-center">
        <div class="container mt-5">
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="../server/<?php echo $data[0]['photo'] ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo $data[0]['title'] ?></h5>
                            <p class="lead"><strong>Описание: </strong> <?php echo $data[0]['description'] ?> </p>
                            <p class="lead"><strong>Цена: </strong> <?php echo $data[0]['price'] ?> </p>
                            <p class="lead"><strong>Категория: </strong> <?php echo $data[0]['title_catgory'] ?> </p>
                            <p class="lead"><strong>Бренд: </strong> <?php echo $data[0]['title_brand'] ?> </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>
        </div>
    </div>
</body>
</html>