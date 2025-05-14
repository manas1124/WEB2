window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component
function test() {
  console.log("test2");
}

async function getAllNhomKs() {
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "POST",
      data: { func: "getAllNhomKs" },
      dataType: "json",
    });
    // console.log("fect",response)
    return response;
  } catch (e) {
    console.log(e)
    console.log("loi fetchdata getAllKhaoSat")
    return null;
  }
}
async function deletenks(id) {
  Swal.fire({
    title: 'Bạn có chắc chắn muốn xóa không?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Có, xóa ngay',
    cancelButtonText: 'Không'
  }).then(async (result) => {
    if (result.isConfirmed) {
      console.log("Deleting user with ID:", id);
      try {
        const response = await $.ajax({
          url: "./controller/nhomKsController.php",
          type: "POST",
          data: { func: "deletenks", id: id }, // Gửi ID người dùng cần xóa
          dataType: "json",
        });

        if (response.success) {
          Swal.fire({
            title: 'Zóa nhóm khảo sát thất bại!',
            icon: 'error',
            confirmButtonText: 'Đã hiểu'
          });

        } else {
          Swal.fire({
            title: 'Xóa nhóm khảo sát thành công!',
            icon: 'success',
            confirmButtonText: 'Đã hiểu'
          }).then((result)=>{
              location.reload();
          });
        }
      } catch (error) {
        console.log("Lỗi khi xóa người dùng");

      }
    }
  });
}
$(function () {

  $(".main-content").on("click", ".action-item", function (e) {
    e.preventDefault();
    let action = $(this).data("act");
    console.log(action)
    $(".main-content").load(`day la trang ${action}`)
  });


  (async () => {
    let ksList = await getAllNhomKs();
    // ksList = JSON.parse(ksList)
    if (ksList != null) {
      // console.log(ksList)

      ksList.map((item) => {
        $("#nhomks-list").append(`
            <tr>
                <td>${item.ten_nks}</td>
               
                <td>
                  <button class="action-item btn btn-circle btn-text btn-sm edit-target hidden" data-act="nhomks-sua" data-id="${item.nks_id}" aria-label="sua khao sat"><span class="icon-[tabler--pencil] size-5"></span></button>
                  <button onclick="deletenks(${item.nks_id})" class="btn btn-circle btn-text btn-sm delete-target hidden" aria-label="xoa khao sat"><span class="icon-[tabler--trash] size-5"></span></button>
                </td>
            </tr>
    
          `);
      });
      window.AppState.applyPermissionControl();

    }



  })();
});