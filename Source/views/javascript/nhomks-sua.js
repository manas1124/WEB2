async function getNhomKsById(id) {
    try {
        const response = await $.ajax({
            url: './controller/nhomKsController.php',
            type: 'POST',
            data: { func: 'getNhomKsById', id: id },
            dataType: 'json',
        });

        if (response.error) {
            console.error('Lỗi khi lấy dữ liệu nhóm khảo sát:', response.error);
            return null;
        }

        return response;
    } catch (error) {
        
        return null;
    }
}

async function updateNhomKs(data) {
    try {
        console.log('Dữ liệu gửi đi:', data); 

        const response = await $.ajax({
            url: './controller/nhomKsController.php',
            type: 'POST',
            data: {
                func: 'updateNhomKs',
                data: JSON.stringify(data),
            },
            dataType: 'json',
        });

        if (response.error) {
            console.log('Lỗi phía server (response.error):', response.error);
            return false;
        }

        console.log('Kết quả response:', response);
        return response;
    } catch (error) {
     
        return false;
    }
}
$(".main-content").on("click", ".action-item", function (e) {
    e.preventDefault();
    let action = $(this).data("act");
    let id = $(this).data("id");
    console.log("Action:", action, "ID:", id);
   
   
  });
$(function () {
    window.HSStaticMethods.autoInit();
    (async () =>{

    const urlParams = new URLSearchParams(window.location.search);
    const nhomKsId = urlParams.get('id');
    console.log('ID nhóm khảo sát lấy từ URL:', nhomKsId);
    const res = await getNhomKsById(nhomKsId);
    console.log("🧾 Phản hồi từ getNhomKsById:", res);
    const defaultData = res;
    console.log("📦 Dữ liệu nhomks:", defaultData);

    $("#ten-nhomks").val(defaultData.ten_nks);
    // Sự kiện khi nhấn nút "Lưu"
    $('#btn-update').on('click', async function (e) {
        e.preventDefault();
    
        const ten_nks = $("#ten-nhomks").val().trim();
    
        if (!ten_nks) {
            alert("Vui lòng nhập tên nhóm khảo sát.");
            return;
        }
    
        const result = await updateNhomKs({
            id: nhomKsId,
            ten_nks: ten_nks
        });
    
        if (result && result.success) {
            alert("Cập nhật nhóm khảo sát thành công!");
           
        } else {
            alert("Cập nhật thất bại. Vui lòng thử lại.");
            console.error(" Lỗi khi cập nhật:", result);
        }
    });
    })();
});
