$(function () {
    const pagesCache = {};
    function loadPage(page, addToHistory = true) {
        // $.ajax({
        //     url: './handle/adminHandler.php', // gửi data tới file php chuyen trang
        //     type: 'POST',
        //     data: { page: page }, 
        //     success: function (response) { //function nhan response tu file php
        //         $('#main-content').html(response); 
                
        //         let newUrl = window.location.pathname + "?page=" + page;

        //         if (addToHistory) {
        //             history.pushState({ page: page }, "", newUrl);
        //         }
        //     }
        // });
        $('#main-content').load("./views/admin/" + page + ".php");
        let newUrl = window.location.pathname + "?page=" + page;

        if (addToHistory) {
        history.pushState({ page: page }, "", newUrl);
        }
    }

    $('.nav-link').on('click', function (e) {
        
        e.preventDefault();
        let page = $(this).data('page');
       
        loadPage(page);
    });

    // Get current URL
let url = window.location.href;
let page = url.split('?page=')[1];
if (!page) {
  page = "ctdtPage";
}
loadPage(page);

});

