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


async function updateks(id) { 
  showModal('update');
  nhomKsId = id;
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
async function addNhomks(ten_nks) {
    try {
      const response = await $.ajax({
        url: "./controller/nhomKsController.php",
        type: "POST",
        data: {
          func: "addNhomks",
          ten_nks: ten_nks,
        },
        dataType: "json",
      });
  
      return response;
    } catch (e) {
      console.error("Lỗi khi thêm nhóm:", e);
      return { success: false, message: "Lỗi kết nối server" };
    }
}

function showModal(mode) {
  $("#basic-modal").removeClass("hidden").addClass("open");
  $("body").css("overflow", "hidden");
  $("#basic-modal").attr("modal-data", mode);
}
function closeModal() {
  $("#basic-modal").removeClass("open").addClass("hidden");
  $("body").css("overflow", "auto");
}



async function action(mode) {
  if (mode === 'create') {
    const ten_nks = $("#ten-nhomks").val().trim();

    if (ten_nks === "") {
      alert("Vui lòng nhập tên nhóm khảo sát!");
      return;
    }

    const result = await addNhomks(ten_nks);
    if (result.success) {
      alert("Thêm thành công!");
      closeModal();
      location.reload();
    } else {
      alert(result.message);
    }
  }
  else {
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
      closeModal();
      location.reload();
      nhomKsId = -1;
    } else {
      alert("Cập nhật thất bại. Vui lòng thử lại.");
      console.error(" Lỗi khi cập nhật:", result);
    }
  }
}


$(function () {

  const nhomKsId = -1;



  $('#btn-save').on('click', async function (e) {
    e.preventDefault();
    const mode = $("#basic-modal").attr("modal-data");
    action(mode);
  });

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
                <button onclick="updateks(${item.nks_id})" class="btn btn-circle btn-text btn-sm delete-target hidden" aria-label="xoa khao sat"><span class="icon-[tabler--pencil] size-5"></span></button>
                <button onclick="deletenks(${item.nks_id})" class="btn btn-circle btn-text btn-sm delete-target hidden" aria-label="xoa khao sat"><span class="icon-[tabler--trash] size-5"></span></button>
              </td>
          </tr>
  
        `);
      });
      window.AppState.applyPermissionControl();
      
    }
    
    

  })();
});
  