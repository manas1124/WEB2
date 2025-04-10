async function getAllChuky(page = 1, status = null) {
    try {
        const response = await $.ajax({
            url: "./controller/chuKyController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllpaging",
                page: page,
                status: status
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadAllChuky(page = 1, status = null) {
    const res = await getAllChuky(page, status);
    if (res) {
        console.log(res);
        const chukyList = res.data;
        const totalPages = res.totalPages;
        const currentPage = res.currentPage;
        $("#chuky-list").empty();
        $("#pagination").empty();
        chukyList.forEach(item => {
            $("#chuky-list").append(`
              <tr>
                    <td>${item.ck_id}</td>
                    <td>${item.ten_ck}</td>
                    <td>${
                        item.status == 1
                          ? '<span class="badge badge-soft badge-success ">Đang sử dụng</span>'
                          : '<span class="badge badge-soft badge-error ">Đã khóa</span>'
                    }</td>
                    <td>
                        <button class="action-sua btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="action-status btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--trash] size-5"></span></button>
                    </td>
                </tr>
            `);
        });
        $("#pagination").append(`<button type="button" class="btn btn-text btn-prev">Previous</button><div class="flex items-center gap-x-1">`);
        for (let i = 1; i <= totalPages; i++) {
            let activeClass = (i == currentPage) ? 'aria-current="page"' : '';
            $("#pagination").append(`
                <button type="button" class="btn btn-text btn-square aria-[current='page']:text-bg-primary btn-page" data-page="${i}" ${activeClass}>${i}</button>
            `);
        }
        $("#pagination").append(`</div><button type="button" class="btn btn-text btn-next">Next</button>`);
    }
}

function create() {
    $.ajax({
        type: "GET",
        url: "./controller/chuKyController.php",
        // url: "./handle/test.php",
        data: params, // Send all parameters
        dataType: "json",
        success: function (response) {
            $("#main-content").html(response.html);
            // Update the URL
            let queryString = $.param(params);
            queryString = cleanQueryString(queryString);
            history.pushState(params, "", "admin.php?" + queryString);
        },
        error: function (error) {
            console.error("Error navigate page:", error);
         
        }
    });
}

function update() {
    $.ajax({
        type: "GET",
        url: "./controller/chuKyController.php",
        // url: "./handle/test.php",
        data: params, // Send all parameters
        dataType: "json",
        success: function (response) {
            $("#main-content").html(response.html);
            // Update the URL
            let queryString = $.param(params);
            queryString = cleanQueryString(queryString);
            history.pushState(params, "", "admin.php?" + queryString);
        },
        error: function (error) {
            console.error("Error navigate page:", error);
         
        }
    });
}

function toggelStatus() {
    $.ajax({
        type: "GET",
        url: "./controller/chuKyController.php",
        // url: "./handle/test.php",
        data: params, // Send all parameters
        dataType: "json",
        success: function (response) {
            $("#main-content").html(response.html);
            // Update the URL
            let queryString = $.param(params);
            queryString = cleanQueryString(queryString);
            history.pushState(params, "", "admin.php?" + queryString);
        },
        error: function (error) {
            console.error("Error navigate page:", error);
         
        }
    });
}

$(document).ready(function () {
    loadAllChuky(1);

    $("#chuky-list").on("click", ".action-sua", function (event) {
        
    });

    $("#btn-loc").on("click", function () {
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllChuky(1, status);
    });

    $("#pagination").on("click", ".btn-page", function (){
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedPage = Number($(this).data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if(currentPage == selectedPage){
            return;
        }
        loadAllChuky(selectedPage, status);
    });

    $("#pagination").on("click", ".btn-prev", function (){
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if(currentPage == 1){
            return;
        }
        currentPage -= 1;
        loadAllChuky(currentPage, status);
    });

    $("#pagination").on("click", ".btn-next", function (){
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if(currentPage == $("#pagination .btn-page]").length){
            return;
        }
        currentPage += 1;
        loadAllChuky(currentPage, status);
    });
});