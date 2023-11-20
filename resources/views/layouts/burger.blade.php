<span class="burger">=</span>
<nav class="nav">
    <ul class="nav__links" id="1">
        <li class="nav__text">Для полного функционала
            войдите в аккаунт</li>
        <li class="nav__link"><a href="/home">На главное меню</a></li>
        <li class="nav__link"><a href="/register">Создать аккаунт</a></li>
        <li class="nav__link"><a href="/login">Войти</a></li>

        <li class="nav__text_other">Прочее:</li>
        <li class="nav__link"><a href="#">Справка</a></li>
    </ul>

    <ul class="nav__links" id="2">
        <li class="nav__text">Мы рады вас видеть</li>
        <li class="nav__link"><a href="/home">На главное меню</a></li>
        <li class="nav__link"><a href="#" id="exit">Выйти</a></li>


        <li class="nav__text_other">Прочее:</li>
        <li class="nav__link"><a href="#">Справка</a></li>
    </ul>
</nav>

<script>
    let menuBtn = document.querySelector('.burger');
    let menu = document.querySelector('.nav');
    menuBtn.addEventListener('click', function(){
        menu.classList.toggle('active');
    })

    $(document).ready ( function(){
        if (localStorage.getItem('token')) {
            $('#1').css('display','none');
        } else {
            $('#2').css('display','none');

        }
    });


    $('#exit').click(function(){
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: 'api/auth/logout',
            type: "DELETE",
            dataType: 'json',
            headers: {"Authorization": "Bearer " + localStorage.getItem('token'),
                'X-CSRF-TOKEN': token},
            success: function (data) {
                localStorage.removeItem('token');
                window.location.href = '/';
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
</script>
