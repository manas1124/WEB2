
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
        console.log(currentParams);
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
