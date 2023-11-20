<span class="burger">=</span>
<nav class="nav">
    <ul class="nav__links" id="1">
        <li class="nav__text">Для полного функционала
            войдите в аккаунт</li>
        <li class="nav__link"><a href="/register">Создать аккаунт</a></li>
        <li class="nav__link"><a href="/login">Войти</a></li>

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
        }
    });
</script>
