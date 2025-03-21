$((function () {
    function loadPage(page, isAdmin = false, addToHistory = true) {
        $.ajax({
            url: '../handle/adminHandler.php',
            type: 'POST',
            data: { page: page, admin: isAdmin },
            success: function (response) {
                $('#content').html(response);

                // Update URL without reloading the page
                let newUrl = window.location.pathname + "?page=" + page;
                if (isAdmin) newUrl += "&admin=true";

                if (addToHistory) {
                    history.pushState({ page: page, admin: isAdmin }, "", newUrl);
                }
            }
        });
    }

    $('.nav-link').on('click', function (e) {
        e.preventDefault();
        let page = $(this).data('page');
        let isAdmin = window.location.pathname.includes("admin.php");
        loadPage(page, isAdmin);
    });

    // Handle back/forward navigation
    window.onpopstate = function (event) {
        if (event.state) {
            loadPage(event.state.page, event.state.admin, false);
        }
    };

    // Load the page from the URL on page load
    const urlParams = new URLSearchParams(window.location.search);
    let page = urlParams.get('page') || (window.location.pathname.includes("admin.php") ? "dashboard" : "home");
    let isAdmin = urlParams.get('admin') === "true";
    loadPage(page, isAdmin, false);
}));
