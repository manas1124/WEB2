$(document).ready(function() {

    // Handle admin subpage navigation
    $('nav a').click(function(e) {
        e.preventDefault();
        let route = $(this).data('route');

        $.ajax({
            url: '/router',
            type: 'POST',
            data: { route: route },
            success: function(response) {
                $('#admin-content').html(response);
                history.pushState({ route: route }, '', route);
            },
            error: function() {
                $('#admin-content').html('Error loading content.');
            }
        });
    });

    // Handle browser back/forward buttons
    $(window).on('popstate', function(event) {
        if (event.originalEvent.state && event.originalEvent.state.route) {
            loadRoute(event.originalEvent.state.route);
        }
    });

    function loadRoute(route) {
        $.ajax({
            url: '/router',
            type: 'POST',
            data: { route: route },
            success: function(response) {
                if(route.startsWith('/admin')){
                    $('#admin-content').html(response);
                } else{
                    $('#content').html(response);
                }
            },
            error: function() {
                if(route.startsWith('/admin')){
                    $('#admin-content').html('Error loading content.');
                } else {
                    $('#content').html('Error loading content.');
                }
            }
        });
    }

    let initialRoute = window.location.pathname;
    if (initialRoute === '') {
        initialRoute = '/user';
    }
    loadRoute(initialRoute);
});