function login() {
    let log = $('#login').val()
    let pas = $('#passw').val()

    $.get('auth.php', {l: log, p: pas}, function(data) {
        let otvet = JSON.parse(data)
        if ('error' in otvet) {
            alert(otvet['error']['text'])
        }
        else if ('user' in otvet) {
            alert('Вы успешно авторизовались')
            localStorage.setItem('token', otvet.user.token)
            window.location.replace("get.cart.php?tk=" + localStorage.getItem('token'));
        }
        else {
            alert('Непредвиденная ошибка')
            console.log(data)
        }
    })
}

function registration() {
    let log = $('#login').val()
    let pas1 = $('#passw1').val()
    let pas2 = $('#passw2').val()
    if (pas1 != pas2) {
        alert('Пароли не совпадают')
    }
    else {
        $.get('register.php', {l: log, p: pas1}, function(data) {
            let otvet = JSON.parse(data)
            if ('error' in otvet) {
                alert(otvet['error']['text'])
            }
            else if ('user' in otvet) {
                alert('Вы успешно зарегестрировались')
                window.location.replace("login.html");
            }
            else {
                alert('Непредвиденная ошибка')
                console.log(data)
            }
        })
    }
}