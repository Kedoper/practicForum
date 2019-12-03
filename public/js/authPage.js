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

    let itemsWhichError = document.querySelectorAll('.form-group.error');

    if (itemsWhichError.length === 0) {
        sendFormData(authData)
    }
}

function sendFormData(data) {
    let actionLoader = document.querySelector('.actionLoad'),
        messageWrap = document.querySelector('.siteMessage'),
        xr = new XMLHttpRequest(),
        body = JSON.stringify(data);

    messageWrap.classList.remove('error');
    messageWrap.classList.remove('success');

    actionLoader.classList.remove("hide");

    xr.open('POST', '/api/users.auth');
    xr.send(body);
    xr.onreadystatechange = function () {
        if (xr.readyState === 4 && xr.status === 200) {
            let response = JSON.parse(xr.response);

            if (response.code !== 0) {
                messageWrap.classList.remove('hide');
                messageWrap.children[0].innerText = response.message;
                messageWrap.classList.add('error');
            } else {
                document.querySelectorAll('input').forEach(input => input.disabled = true);
                document.querySelectorAll('button').forEach(button => button.disabled = true);

                messageWrap.children[0].innerText = "И так, все окей, сейчас отправим вас на форум!";
                messageWrap.classList.add('success');
                messageWrap.classList.remove('hide');
                setTimeout(() => location.href = '/', 2000);
            }
            setTimeout(() => actionLoader.classList.add('hide'), 600);
        }
    }

}