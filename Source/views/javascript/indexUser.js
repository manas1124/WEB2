// $((function () {
//     function loadPage(page, isAdmin = false, addToHistory = true) {
//         $.ajax({
//             url: '../handle/adminHandler.php',
//             type: 'POST',
//             data: { page: page, admin: isAdmin },
//             success: function (response) {
//                 $('#content').html(response);

//                 // Update URL without reloading the page
//                 let newUrl = window.location.pathname + "?page=" + page;
//                 if (isAdmin) newUrl += "&admin=true";

//                 if (addToHistory) {
//                     history.pushState({ page: page, admin: isAdmin }, "", newUrl);
//                 }
//             }
//         });
//     }

//     $('.nav-link').on('click', function (e) {
//         e.preventDefault();
//         let page = $(this).data('page');
//         let isAdmin = window.location.pathname.includes("admin.php");
//         loadPage(page, isAdmin);
//     });

//     // Handle back/forward navigation
//     window.onpopstate = function (event) {
//         if (event.state) {
//             loadPage(event.state.page, event.state.admin, false);
//         }
//     };

//     // Load the page from the URL on page load
//     const urlParams = new URLSearchParams(window.location.search);
//     let page = urlParams.get('page') || (window.location.pathname.includes("admin.php") ? "dashboard" : "home");
//     let isAdmin = urlParams.get('admin') === "true";
//     loadPage(page, isAdmin, false);
// }));



$('#loginForm').on('submit', function(e){
    e.preventDefault(); 

    $.ajax({
        type: 'POST',
        url: '/Source/controller/AuthController.php', 
        data: {
            action: 'login',
            username: $('#username').val(), 
            password: $('#password').val()
        }, 
        success: function (response) {
            // console.log(response);

            var data = JSON.parse(response);
            alert(data['message']); // Show the message from the server


        },
        error: function() {
            alert('Có lỗi xảy ra khi gửi dữ liệu!');
        }
    });
});
// $(function () {
//   function loadPage(page, isUser = false, addToHistory = true) {
//     $.ajax({
//       url: "../handle/userHandler.php",
//       type: "POST",
//       data: { page: page, user: isUser },
//       success: function (response) {
//         $("#content").html(response);

//         // Update URL without reloading the page
//         let newUrl = window.location.pathname + "?page=" + page;
//         if (isUser) newUrl += "&user=true";

//         if (addToHistory) {
//           history.pushState({ page: page, user: isUser }, "", newUrl);
//         }
//       },
//     });
//   }

//   $(".nav-link").on("click", function (e) {
//     e.preventDefault();
//     let page = $(this).data("page");
//     let isUser = window.location.pathname.includes("user.php");
//     loadPage(page, isUser);
//   });

//   // Handle back/forward navigation
//   window.onpopstate = function (event) {
//     if (event.state) {
//       loadPage(event.state.page, event.state.admin, false);
//     }
//   };

//   // Load the page from the URL on page load
//   const urlParams = new URLSearchParams(window.location.search);
//   let page =
//     urlParams.get("page") ||
//     (window.location.pathname.includes("admin.php") ? "dashboard" : "home");
//   let isUser = urlParams.get("admin") === "true";
//   loadPage(page, isUser, false);
// });
$(function () {
    // Function to update content and URL
    function updateContent(params) {
        $.ajax({
            type: "GET",
            url: "./handle/userHandler.php",
            // url: "./handle/test.php",
            data: params, // Send all parameters
            dataType: "json",
            success: function (response) {
                $("#main-content").html(response.html);
                // Update the URL
                let queryString = $.param(params);
                queryString = cleanQueryString(queryString);
                history.pushState(params, "", "user.php?" + queryString);
            },
            error: function (error) {
                console.error("Error navigate page:", error);
             
            }
        });
    }

    // Menu Item Click Handler
    $(".nav-item").on("click", function (event) {
        event.preventDefault();
        let page = $(this).data("page");
        let currentParams = getUrlParams();
        console.log(currentParams)
        // console.log(page)
        // Clean 'act' when changing 'page'
        let newParams = { page: page };
        updateContent(newParams);
    });

    $("#main-content").on("click", ".back-link", function (event) {
        event.preventDefault();
        history.back(); // Go back one step in history
    });

    // Xu li truyen tham số khi click ".action-item"(link bên trong main-content) sửa( tự truyền thêm id)
    $("#main-content").on("click", ".action-item", function (event) {
        event.preventDefault();
        let act = $(this).data("act");
        let currentParams = getUrlParams();
        let newParams = { ...currentParams, act: act};

        // xử lí này sẽ truyền param lên url vd: ..act="them"&id=3
        let id = $(this).data("id");
        if (id !=null) {
            newParams = { ...currentParams, act: act, id:id};
        }
        
        updateContent(newParams);
    });

    // Helper function to get URL parameters
    function getUrlParams() {
        let params = {};
        let queryString = window.location.search.substring(1);
        if (queryString) {
            let paramPairs = queryString.split("&");
            for (let i = 0; i < paramPairs.length; i++) {
                let pair = paramPairs[i].split("=");
                params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || "");
            }
        }
        return params;
    }

    // Handle popstate event (back/forward buttons)
    window.addEventListener("popstate", function (event) {
        if (event.state) {
            updateContent(event.state);
        } else {
            // Handle cases where state is null (e.g., initial page load)
            let initialParams = getUrlParams();
            updateContent(initialParams);
        }
    });

});
