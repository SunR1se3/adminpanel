function sendData() {
    let photo = document.getElementById("formFile").files[0];
    let url_card = "http://localhost/view/" + document.getElementById("url_card").value;
    let status = document.querySelector('input[name="status"]:checked').value;
    let elements = document.getElementsByClassName("formVal");
    var formData = new FormData();
    for(var i=0; i<elements.length - 1; i++)
    {
        console.log(elements[i].name + "   " + elements[i].value);
        formData.append(elements[i].name, elements[i].value);
    }
    formData.append("status", status);
    formData.append("photo", photo);
    formData.append("url_card", url_card);
    console.log(formData.get("status"));
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            let alert = document.getElementById('alert-s');
            alert.classList.remove('d-none');
            setTimeout(() => {
                alert.classList.add('d-none');
            }, 3000);
        }
    }
    xmlHttp.open("post", "http://localhost/server/ProductService.php");
    xmlHttp.send(formData);
}

function removeProduct() {
    let id = document.getElementById('removeButton').value;
    let formData = new FormData();
    formData.append("id", id);
    formData.append("delete", true);

    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            console.log("OK delete");
        }
    }
    xmlHttp.open("post", "http://localhost/server/ProductService.php");
    xmlHttp.send(formData);
}

function changeStatus(id) {
    let formData = new FormData();
    formData.append("id", id);
    formData.append("status", document.getElementById(id).checked ? 1 : 0);
    formData.append("changeStatus", true);
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            console.log("OK changed");
        }
    }
    xmlHttp.open("post", "http://localhost/server/ProductService.php");
    xmlHttp.send(formData);
}

function changeData() {
    let id = document.getElementsByClassName('btn-primary')[0].id;
    let photo = document.getElementById("formFile").files[0];
    if (photo == undefined) photo = document.getElementsByClassName('photo-path')[0].id;
    let url_card = "http://localhost/view/" + document.getElementById("url_card").value;
    let status = document.querySelector('input[name="status"]:checked').value;
    let elements = document.getElementsByClassName("formVal");
    var formData = new FormData();
    for(var i=0; i<elements.length - 1; i++)
    {
        formData.append(elements[i].name, elements[i].value);
    }
    formData.append("status", status);
    formData.append("photo", photo);
    formData.append("url_card", url_card);
    formData.append("updateData", true);
    formData.append("id", id);
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            let alert = document.getElementById('alert-s');
            alert.classList.remove('d-none');
            setTimeout(() => {
                alert.classList.add('d-none');
            }, 3000);
        }
    }
    xmlHttp.open("post", "http://localhost/server/ProductService.php");
    xmlHttp.send(formData);
}

function search() {
    let title = document.getElementById('title_search').value;
    let brand = document.getElementById('brandId').value;
    let category = document.getElementById('categoryId').value;
    let price_start = document.getElementById('price_start').value;
    let price_end = document.getElementById('price_end').value;

    var formData = new FormData();

    if (title != "") formData.append("title", title);
    if (brand != "Бренд не выбран") formData.append("brandId", brand);
    if (category != "Категория не выбрана") formData.append("categoryId", category);

    if (price_start != "" && price_end != "") {
        formData.append("price_start", price_start);
        formData.append("price_end", price_end);
    } else if (price_start != "" && price_end == "") {
        formData.append("price_start", price_start);
    } else if (price_start == "" && price_end != "") {
        formData.append("price_end", price_end);
    }

    formData.append("getSearchedData", true);
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            console.log("ok search");
            let response = xmlHttp.responseText;
            let json = JSON.parse(response);
            let tbody = document.getElementById('tbody');
            tbody.innerHTML = "";
            for (let i = 0; i < json.length; i++) {
                let edit_url = json[i]['url_card'].replace('view', 'edit');
                tbody.innerHTML += `<tr><td>${json[i]['title']}</td> <td>${json[i]['description']}</td> <td>${json[i]['photo']}</td> <td><a href="${edit_url}">${edit_url}</a></td> <td><a href="${json[i]['url_card']}">${json[i]['url_card']}</a></td> <td>${json[i]['price']}</td> <td><div class="form-check form-switch"><input class="form-check-input" value="${json[i]['status']}" type="checkbox" id="${json[i]['id']}" oninput="changeStatus(id)"></div></td> <td>${json[i]['title_catgory']}</td> <td>${json[i]['title_brand']}</td> <td><button type="button" class="btn btn-danger" value="${json[i]['id']}" onclick="removeProduct()" id="removeButton">Удалить</button></td></tr>`;
            }

            let statuses = document.getElementsByClassName('form-check-input');

            for (let i = 0; i < statuses.length; i++) {
                if (statuses[i].value == 1) statuses[i].checked = true;
            }
        }
    }
    xmlHttp.open("post", "http://localhost/server/ProductService.php")
    xmlHttp.send(formData);
}

function sortPrice() {
    let formData = new FormData();
    formData.append("sortPrice", true);

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            let response = xmlHttp.responseText;
            let json = JSON.parse(response);
            let tbody = document.getElementById('tbody');
            tbody.innerHTML = "";
            for (let i = 0; i < json.length; i++) {
                let edit_url = json[i]['url_card'].replace('view', 'edit');
                tbody.innerHTML += `<tr><td>${json[i]['title']}</td> <td>${json[i]['description']}</td> <td>${json[i]['photo']}</td> <td><a href="${edit_url}">${edit_url}</a></td> <td><a href="${json[i]['url_card']}">${json[i]['url_card']}</a></td> <td>${json[i]['price']}</td> <td><div class="form-check form-switch"><input class="form-check-input" value="${json[i]['status']}" type="checkbox" id="${json[i]['id']}" oninput="changeStatus(id)"></div></td> <td>${json[i]['title_catgory']}</td> <td>${json[i]['title_brand']}</td> <td><button type="button" class="btn btn-danger" value="${json[i]['id']}" onclick="removeProduct()" id="removeButton">Удалить</button></td></tr>`;
            }

            let statuses = document.getElementsByClassName('form-check-input');

            for (let i = 0; i < statuses.length; i++) {
                if (statuses[i].value == 1) statuses[i].checked = true;
            }
        }
    }
    xmlHttp.open("post", "http://localhost/server/ProductService.php");
    xmlHttp.send(formData);
}

function sortTitle() {
    let formData = new FormData();
    formData.append("sortTitle", true);

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function()
    {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            let response = xmlHttp.responseText;
            let json = JSON.parse(response);
            let tbody = document.getElementById('tbody');
            tbody.innerHTML = "";
            for (let i = 0; i < json.length; i++) {
                let edit_url = json[i]['url_card'].replace('view', 'edit');
                tbody.innerHTML += `<tr><td>${json[i]['title']}</td> <td>${json[i]['description']}</td> <td>${json[i]['photo']}</td> <td><a href="${edit_url}">${edit_url}</a></td> <td><a href="${json[i]['url_card']}">${json[i]['url_card']}</a></td> <td>${json[i]['price']}</td> <td><div class="form-check form-switch"><input class="form-check-input" value="${json[i]['status']}" type="checkbox" id="${json[i]['id']}" oninput="changeStatus(id)"></div></td> <td>${json[i]['title_catgory']}</td> <td>${json[i]['title_brand']}</td> <td><button type="button" class="btn btn-danger" value="${json[i]['id']}" onclick="removeProduct()" id="removeButton">Удалить</button></td></tr>`;
            }

            let statuses = document.getElementsByClassName('form-check-input');

            for (let i = 0; i < statuses.length; i++) {
                if (statuses[i].value == 1) statuses[i].checked = true;
            }
        }
    }
    xmlHttp.open("post", "http://localhost/server/ProductService.php");
    xmlHttp.send(formData);
}



