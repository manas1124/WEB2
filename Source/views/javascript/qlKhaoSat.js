function test() {
    console.log("test2")
}
async function getAllKhaoSat() {
    try {
        const response = await $.ajax({
            url: './controller/KhaoSatController.php',
            type: 'POST',
            data: { func: "getAllKhaoSat", data: { 'a': 'b' } },
            dataType: 'json'
        });
        return response; // Directly return the JSON response
    } catch (error) {
        return { error: `AJAX error: ${error.status} - ${error.statusText}` };
    }
}

function getKhaoSatById(id) {
    $.ajax({
        url: './controller/KhaoSatController.php', // gửi data tới file php chuyen trang
        type: 'POST',
        data: { func:"getAllKhaoSat", data:{'a':'b'}}, 
        success: function (response) { //function nhan response tu file php
            console.log(response);
            // return response.json();
        }
    });
}
$(function () {
    
    (async () => {
        const data = await getAllKhaoSat();
        console.log(data); // This will be the JSON object
    })();
});