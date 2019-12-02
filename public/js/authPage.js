document.querySelector('form').addEventListener("submit", formHandler);

function formHandler(e) {
    e.preventDefault();
    let authData = {};
    document.querySelectorAll('input').forEach(value => {
        let inputValue = value.value;
        if (inputValue.length === 0) {
            value.parentNode.classList.add("error");
            value.parentNode.dataset.error_text = "Введите хоть что-нибудь";
            authData[[value.name]] = "";
        } else {
            value.parentNode.classList.remove("error");
            value.parentNode.removeAttribute("data-error_text");
            authData[[value.name]] = value.value;
        }
    });
    for (let key in authData) {
        if (authData[key] !== "") {
            let input = document.querySelector(`[name="${key}"]`);
            if (input.value.length < 3) {
                input.parentNode.classList.add("error");
                input.parentNode.dataset.error_text = "Слишком коротко";
            } else {
                input.parentNode.classList.remove("error");
                input.parentNode.removeAttribute("data-error_text");
            }
        }
    }

    let itemsWhichError = document.querySelectorAll('.error');

    if (itemsWhichError.length === 0) {
        sendFormData(authData)
    }
}

function sendFormData(data) {
    let actionLoader = document.querySelector('.actionLoad'),
        xr = new XMLHttpRequest(),
        body = JSON.stringify(data);
    actionLoader.classList.remove("hide");
    xr.open('POST', '/api/users.create');
    xr.send(body);
    xr.onreadystatechange = function () {
        if (xr.readyState === 4 && xr.status === 200) {
            let response = JSON.parse(xr.response);
            actionLoader.classList.add('hide');
        }
    }

}