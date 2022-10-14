<?php require "server/ProductService.php"; $_GET = [1 => "get_all"]; ?>
<?php require "server/BrandService.php" ?>
<?php require "server/CategoryService.php" ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="../js/ajax.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link">Добавить товар</a></li>
            <li class="nav-item"><a href="/List" class="nav-link">Список товаров</a></li>
        </ul>
    </header>
    <p class="lead text-center mt-5">Список товаров</p>
    <div class="container mt-5">
        <div class="row mt-5 mb-5">
            <div class="col-sm">
                <input class="form-control" type="text" placeholder="Название" id="title_search" name="title_search">
            </div>
            <div class="col-sm">
                <select class="form-select formVal" name="brandId" id="brandId">
                    <option selected>Бренд не выбран</option>
                    <?php foreach ($data_brand as $item) { ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo $item['title'] ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-sm">
                <select class="form-select formVal" name="categoryId" id="categoryId">
                    <option selected>Категория не выбрана</option>
                    <?php foreach ($data_category as $item) { ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo $item['title'] ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-sm">
                <div class="row">
                    <input type="number" class="form-control formVal w-50" id="price_start" name="price_start" placeholder="от">
                    <input type="number" class="form-control formVal w-50" id="price_end" name="price_end" placeholder="до">
                </div>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-primary" name="bt-search" onclick="search();">Найти</button>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="click-col" onclick="sortTitle()">Название</th>
                <th scope="col">Описание</th>
                <th scope="col">Фото</th>
                <th scope="col">Ссылка на редактирование</th>
                <th scope="col">Ссылка на карточку</th>
                <th scope="col" class="click-col" onclick="sortPrice()">Цена</th>
                <th scope="col">Статус</th>
                <th scope="col">Категория</th>
                <th scope="col">Бренд</th>
                <th scope="col">Удаление</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <?php foreach ($data as $row) { ?>
                <tr>
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $row['description'] ?></td>
                    <td><?php echo $row['photo'] ?></td>
                    <td><a href="<?php echo str_replace("view", "edit", $row['url_card']) ?>"><?php echo str_replace("view", "edit", $row['url_card']) ?></a></td>
                    <td><a href="<?php echo $row['url_card'] ?>"><?php echo $row['url_card'] ?></a></td>
                    <td><?php echo $row['price'] ?></td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" value="<?php echo $row['status'] ?>" type="checkbox" id="<?php echo $row['id'] ?>" <?php if ($row['status'] == 1) echo "checked" ?> oninput="changeStatus(id)">
                        </div>
                    </td>
                    <td><?php echo $row['title_catgory'] ?></td>
                    <td><?php echo $row['title_brand'] ?></td>
                    <td><button type="button" class="btn btn-danger" value="<?php echo $row['id'] ?>" onclick="removeProduct()" id="removeButton">Удалить</button></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>