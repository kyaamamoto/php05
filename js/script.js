$(document).ready(function(){
    // 5-1-26 追従メニューの現在地ハイライト
    var elemTop = [];
    function PositionCheck(){
        var headerH = $("#header").outerHeight(true);
        $(".scroll-point").each(function(i) {
            elemTop[i] = Math.round(parseInt($(this).offset().top - headerH - 10));
        });
    }

    function ScrollAnime() {
        var scroll = Math.round($(window).scrollTop());
        var NavElem = $("#pc-nav li");
        $("#pc-nav li").removeClass('current');
        if(scroll >= elemTop[0] && scroll < elemTop[1]) { $(NavElem[0]).addClass('current'); } 
        else if(scroll >= elemTop[1] && scroll < elemTop[2]) { $(NavElem[1]).addClass('current'); } 
        else if(scroll >= elemTop[2] && scroll < elemTop[3]) { $(NavElem[2]).addClass('current'); } 
        else if(scroll >= elemTop[3] && scroll < elemTop[4]) { $(NavElem[3]).addClass('current'); } 
        else if(scroll >= elemTop[4]) { $(NavElem[4]).addClass('current'); } 
    }

    $('#pc-nav a, #g-nav a').click(function () {
        var elmHash = $(this).attr('href');
        var headerH = $("#header").outerHeight(true);
        var pos = Math.round($(elmHash).offset().top - headerH);
        $('body,html').animate({scrollTop: pos}, 500, function() {
            // アニメーションの後に展開させる
            triggerAnimations();
        });
        return false;
    });

    // ローディングエリア
    $(window).on('load', function(){
        $("#splash-logo").delay(1200).fadeOut('slow');
        $("#splash").delay(1500).fadeOut('slow', function(){
            $('body').addClass('appear');
            PositionCheck();
            ScrollAnime();
            triggerAnimations();
        });
    });

    $(window).scroll(function () {
        ScrollAnime();
        triggerAnimations();
    });

    // ニュースティッカー
    $('.slider').bxSlider({
        mode: 'vertical',
        controls: false,
        auto: true,
        pager: false
    });

    // ページトップボタンの表示・非表示
    var topBtn = $('#page-top');    
    topBtn.hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            topBtn.fadeIn();
        } else {
            topBtn.fadeOut();
        }
    });
    topBtn.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });

    // クリックでナビゲーションの開閉
    $(".openbtn").click(function () {
        $(this).toggleClass('active');
        $("#g-nav").toggleClass('panelactive');
    });

    $("#g-nav a").click(function () {
        $(".openbtn").removeClass('active');
        $("#g-nav").removeClass('panelactive');
    });

    // アコーディオンの設定
    $('.title').on('click', function() {
        $('.box').slideUp(500);
        var findElm = $(this).next(".box");
        if($(this).hasClass('close')){
            $(this).removeClass('close');
        }else{
            $('.close').removeClass('close');
            $(this).addClass('close');
            $(findElm).slideDown(500);
        }
    });

    // スクロールアニメーションの設定
    function triggerAnimations(){
        fadeAnime();
    }

    function fadeAnime(){
        $('.bgLRextendTrigger').each(function(){
            var elemPos = $(this).offset().top - 50;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll >= elemPos - windowHeight){
                $(this).addClass('bgLRextend');
            }else{
                $(this).removeClass('bgLRextend');
            }
        });	

        $('.bgappearTrigger').each(function(){
            var elemPos = $(this).offset().top - 50;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll >= elemPos - windowHeight){
                $(this).addClass('bgappear');
            }else{
                $(this).removeClass('bgappear');
            }
        });

        $('.fadeUpTrigger').each(function(){
            var elemPos = $(this).offset().top - 50;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll >= elemPos - windowHeight){
                $(this).addClass('fadeUp');
            }else{
                $(this).removeClass('fadeUp');
            }
        });

        $('.flipLeftTrigger').each(function(){
            var elemPos = $(this).offset().top - 50;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll >= elemPos - windowHeight){
                $(this).addClass('flipLeft');
            }else{
                $(this).removeClass('flipLeft');
            }
        });
    }

    $(window).scroll(function () {
        triggerAnimations();
    });

    $(window).on('resize', function() {
        PositionCheck();
    });
});