window.AppState = {
    acc: null,
    applyPermissionControl: function () {
        if (!this.acc || !this.acc.permission) return;

        this.acc.permission.forEach(permission => {
            let className = "." + permission.replaceAll(".", "-");
            $(className).removeClass("hidden");
        });
    }
};

$(function () {
    //check login, xu ly neu da dang nhap
    (async () => {
        const acc = await getCurrentLoginAccount();
        console.log(acc);
        if (acc == null) {
            window.location.href = "./logad.php";
            return;
        } else {
            window.AppState.acc = acc;
            console.log("admin", acc);
            const userInfor = await getUserById(acc.dtId);
            console.log("infor", userInfor);
            let username = userInfor.ho_ten;
            $("#dropdown-bottom-infor").text(username);
            $("#dropdown-bottom-infor").removeClass("hidden");
            window.AppState.applyPermissionControl();
        }
    })();

    //navigate
    // Function to update content and URL
    function updateContent(params) {
        $.ajax({
            type: "GET",
            url: "./handle/adminHandler.php",
            // url: "./handle/test.php",
            data: params, // Send all parameters
            dataType: "json",
            success: function (response) {
                $("#main-content").html(response.html);
                // Update the URL
                window.AppState.applyPermissionControl();
                let queryString = $.param(params);
                queryString = cleanQueryString(queryString);
                history.pushState(params, "", "admin.php?" + queryString);
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
        let newParams = { ...currentParams, act: act };

        // xử lí này sẽ truyền param lên url vd: ..act="them"&id=3
        let id = $(this).data("id");
        if (id != null) {
            newParams = { ...currentParams, act: act, id: id };
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

    // Initial load: Load content based on URL parameters
    let initialParams = getUrlParams();
    const defaultPage = "qlKhaoSatPage"; // Set your default page here
    if (Object.keys(initialParams).length > 0) {
        updateContent(initialParams);
    } else {
        // If no parameters are present, load the default page
        updateContent({ page: defaultPage });
    }

    // Function to clean the query string
    function cleanQueryString(queryString) {
        let params = {};
        if (queryString) {
            let paramPairs = queryString.split("&");
            for (let i = 0; i < paramPairs.length; i++) {
                let pair = paramPairs[i].split("=");
                let key = decodeURIComponent(pair[0]);
                let value = decodeURIComponent(pair[1] || "");
                if (value !== "") {
                    params[key] = value;
                }
            }
        }
        return $.param(params);
    }

    // xu ly sau

    $(".btn-logout").on("click", function () {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn đăng xuất?',
            text: "Bạn sẽ phải đăng nhập lại nếu muốn tiếp tục sử dụng.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đăng xuất',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                logout();
            }
        });
    })
    $(document).on('click', function (e) {
        var sidebar = $('#default-sidebar');
        var toggleBtn = $('[data-overlay="#default-sidebar"]');

        // Nếu click không nằm trong sidebar và không phải nút mở
        if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 &&
            !toggleBtn.is(e.target) && toggleBtn.has(e.target).length === 0) {
            sidebar.removeClass('open opened');
            toggleBtn.attr('aria-expanded', 'false');
        }
    });
});

function logout() {
    $.ajax({
        type: 'POST',
        url: './controller/AuthController.php',
        data: { action: 'logout' },
        success: function (response) {
            console.log(response);

            var data = JSON.parse(response);
            alert(data['message']); // Show the message from the server
            window.location.href = "./logad.php";

        },
        error: function () {
            alert('Có lỗi xảy ra khi gửi dữ liệu!');
        }
    });
}

async function getCurrentLoginAccount() {
    try {
        const response = await $.ajax({
            url: "./controller/AuthController.php",
            type: "POST",
            dataType: "json",
            data: { func: "getCurrentLoginUser" },
        });
        if (response.status == 'error') {
            console.log(response.message)
            return null;
        }
        return response.userInfor;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getUserById(id) {
    try {
        const response = await $.ajax({

            url: "./controller/UserController.php",
            type: "POST",
            data: { func: "getUserById", id: id },
            dataType: "json",
        });
        console.log(" Phản hồi getUserById:", response.data);
        return response.data;
    } catch (error) {
        console.log("Lỗi khi lấy dữ liệu người dùng", error);
        return null;
    }
}
