$(function () {
  function loadPage(page, isUser = false, addToHistory = true) {
    $.ajax({
      url: "../handle/userHandler.php",
      type: "POST",
      data: { page: page, user: isUser },
      success: function (response) {
        $("#content").html(response);

        // Update URL without reloading the page
        let newUrl = window.location.pathname + "?page=" + page;
        if (isUser) newUrl += "&user=true";

        if (addToHistory) {
          history.pushState({ page: page, user: isUser }, "", newUrl);
        }
      },
    });
  }

  $(".nav-link").on("click", function (e) {
    e.preventDefault();
    let page = $(this).data("page");
    let isUser = window.location.pathname.includes("user.php");
    loadPage(page, isUser);
  });

  // Handle back/forward navigation
  window.onpopstate = function (event) {
    if (event.state) {
      loadPage(event.state.page, event.state.admin, false);
    }
  };

  // Load the page from the URL on page load
  const urlParams = new URLSearchParams(window.location.search);
  let page =
    urlParams.get("page") ||
    (window.location.pathname.includes("admin.php") ? "dashboard" : "home");
  let isUser = urlParams.get("admin") === "true";
  loadPage(page, isUser, false);
});
