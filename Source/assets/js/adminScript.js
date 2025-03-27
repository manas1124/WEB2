
/*
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
    $("#main-content").load("./views/admin/" + page + ".php");
    let newUrl = window.location.pathname + "?page=" + page;
    if (addToHistory) {
      history.pushState({ page: page }, "", newUrl);
    }
  }

  $(".nav-link").on("click", function (e) {
    e.preventDefault();
    let page = $(this).data("page");

    loadPage(page);
  });

  // Get current URL
  let url = window.location.href;
  let page = url.split("?page=")[1];
  if (!page) {
    page = "ctdtPage";
  }
  loadPage(page);
 
});
*/
//==========================================================
//===============================================
$(function () {
    $('.nav-link').on('click', function (e) {
        e.preventDefault();
        $('.nav-link').removeClass('active');
        $(this).addClass('active');

        let page = $(this).data('page');

        // Remove previous scripts before loading new page.
        $('.nav-link').each(function () {
            let previousPage = $(this).data('page');
            if (previousPage !== page) {
                removeSubpageScript(previousPage);
            }
        });

        $('#main-content').load("./views/admin/" + page + ".php", function () {
            let script = document.createElement('script');
            script.src = './views/javascript/' + page + '.js';
            script.type = 'text/javascript';
            script.id = page + '-script';

            if (!document.getElementById(page + '-script')) {
                // Check if the script file exists before appending
                $.ajax({
                    url: script.src,
                    type: 'HEAD',
                    success: function () {
                        // File exists, append the script
                        document.body.appendChild(script);
                    },
                    error: function () {
                        // File does not exist, handle the error (optional)
                        console.warn('JavaScript file not found: ' + script.src);
                        // You could add a fallback or show a message to the user here.
                    }
                });
            }
        });
    });

    // Function to remove the JavaScript file when leaving the subpage
    function removeSubpageScript(page) {
        let script = document.getElementById(page + '-script');
        if (script) {
            script.remove();
        }
    }
});