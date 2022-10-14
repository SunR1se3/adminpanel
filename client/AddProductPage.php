<?php require "server/CategoryService.php"?>
<?php require "server/BrandService.php"?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавить товар</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../js/ajax.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link">Добавить товар</a></li>
            <li class="nav-item"><a href="List" class="nav-link">Список товаров</a></li>
        </ul>
    </header>

    <div class="container mt-5 w-25">
        <form id="formAdd" enctype="application/x-www-form-urlencoded" onsubmit="sendData(); return false"> <!-- action="../server/ProductService.php" -->
            <div class="mb-3">
                <label for="title" class="form-label">Название товара</label>
                <input type="text" class="form-control formVal" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="description">Описание</label>
                <textarea class="form-control formVal" id="description" rows="3" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="url_card" class="form-label">URL карточки</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3">http://localhost/view/</span>
                    <input type="text" class="form-control" id="url_card" aria-describedby="basic-addon3" name="url_card">
                </div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Цена</label>
                <input type="number" class="form-control formVal" id="price" name="price">
            </div>
            <label for="radio-btn" class="form-label">Статус</label>
            <div class="form-check" id="radio-btn">
                <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="1" checked >
                <label class="form-check-label" for="flexRadioDefault1">
                    Вкл
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="0">
                <label class="form-check-label" for="flexRadioDefault2">
                    Выкл
                </label>
            </div>
            <div class="mb-3">
                <select class="form-select formVal" name="categoryId">
                    <?php foreach ($data_category as $item) { ?>
                    <option value="<?php echo $item['id'] ?>"><?php echo $item['title'] ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="mb-3">
                <select class="form-select formVal" name="brandId">
                    <?php foreach ($data_brand as $item) { ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo $item['title'] ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Фото</label>
                <input class="form-control formVal" type="file" id="formFile" name="photo">
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>

            <div class="alert alert-success mt-5 mb-5 d-none" role="alert" id="alert-s">
                Данные добавлены!
            </div>
        </form>
    </div>
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>