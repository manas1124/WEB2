window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component
function test() {
  console.log("test2");
}

async function getAllNhomKs() {
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "POST",
      data: { func: "getAllNhomKs"},
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

     console.log("Deleting user with ID:", id);
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "POST",
      data: { func: "deletenks", id: id }, // Gửi ID người dùng cần xóa
      dataType: "json",
    });
  
    if (response.success) {
      alert("xóa thất bại"); 
      
    } else {
      alert("xóa thành công"); 
      location.reload();
    }
  } catch (error) {
    console.log("Lỗi khi xóa người dùng");
    
  }
}
$(function () {

    $(".main-content").on("click",".action-item", function (e) {
        e.preventDefault();
        let action = $(this).data("act");
        console.log(action)
        $(".main-content").load(`day la trang ${action}`)
    });
  
  
    (async () => {
      let ksList  = await getAllNhomKs();
      // ksList = JSON.parse(ksList)
      if (ksList != null) {
        // console.log(ksList)
        
        ksList.map((item) => {
          $("#nhomks-list").append(`
            <tr>
                <td>${item.ten_nks}</td>
               
                <td>
                  <button class="action-item btn btn-circle btn-text btn-sm" data-act="nhomks-sua" data-id="${item.nks_id}" aria-label="sua khao sat"><span class="icon-[tabler--pencil] size-5"></span></button>
                  <button onclick="deletenks(${item.nks_id})" class="btn btn-circle btn-text btn-sm" aria-label="xoa khao sat"><span class="icon-[tabler--trash] size-5"></span></button>
                </td>
            </tr>
    
          `);
        });
        
      }
      
      
  
    })();
  });