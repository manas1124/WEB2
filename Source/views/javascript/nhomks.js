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
  Swal.fire({
    title: 'Cảnh báo',
    text: "Bạn có chắc chắn muốn xóa nhóm khảo sát này không?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Chắc chắn',
    cancelButtonText: 'Hủy',
    cancelButtonColor: '#d33',
  }).then((result) => {   
    if (result.isConfirmed) {
      try {
        const response = $.ajax({
          url: "./controller/nhomKsController.php",
          type: "POST",
          data: { func: "deletenks", id: id }, // Gửi ID người dùng cần xóa
          dataType: "json",
        });
      
        if (response.success) {
          Swal.fire({
            title: 'Thất bại',
            text: "Đã xóa nhóm khảo sát không thành công",
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Thử lại',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
          });
          
        } else {
          Swal.fire({
            title: 'Thành công',
            text: "Đã xóa nhóm khảo sát thành công 1",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Đồng ý',
            cancelButtonColor: '#d33'
          }).then(() => {
            location.reload(); 
          });
          
        }
      } catch (error) {
        Swal.fire({
            title: 'Thất bại',
            text: "Lỗi khi xoá người dùng",
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Thử lại',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
          });
        
      }
    }
  });
  
}


async function updateks(id, tenNksInput) { 
  nhomKsId = id;
  tenNks = tenNksInput;
  showModal('update'); 
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
  if (mode === "update") {
    $("#modal-title").text("Cập nhật nhóm khảo sát");
    $("#btn-save").text("Cập nhật");
    $("#ten-nhomks").val(tenNks);
  } 
  else {
    $("#modal-title").text("Thêm nhóm khảo sát");
    $("#btn-save").text("Thêm");
    $("#ten-nhomks").val('');
  }

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
      Swal.fire({
        title: 'Thành công',
        text: "Thêm nhóm khảo sát thành công",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Đồng ý',
        cancelButtonColor: '#d33'
      }).then(() => {
        closeModal();
        location.reload(); 
      });
    }
    else {
      Swal.fire({
        title: 'Thất bại',
        text: "Thêm nhóm khảo sát không thành công",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
      closeModal();
      location.reload();
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
      Swal.fire({
        title: 'Thành công',
        text: "Cập nhật nhóm khảo sát thành công",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Đồng ý',
        cancelButtonColor: '#d33'
      }).then(() => {
        closeModal();
        location.reload(); 
        nhomKsId = -1;
      });
    } else {
      Swal.fire({
        title: 'Thất bại',
        text: "Cập nhật nhóm khảo sát không thành công",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });

      console.error(" Lỗi khi cập nhật:", result);
    }
  }
}

  $(function () {

    let nhomKsId = -1;
    let tenNks = "";


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
              <td>${item.nks_id}</td>
              <td>${item.ten_nks}</td>
              
              <td>
                <button onclick="updateks(${item.nks_id}, '${item.ten_nks}')" class="btn btn-circle btn-text btn-sm delete-target hidden" aria-label="xoa khao sat"><span class="icon-[tabler--pencil] size-5"></span></button>
                <button onclick="deletenks(${item.nks_id})" class="btn btn-circle btn-text btn-sm delete-target hidden" aria-label="xoa khao sat"><span class="icon-[tabler--trash] size-5"></span></button>
              </td>
          </tr>
  
        `);
        });
        window.AppState.applyPermissionControl();
      
      }
    
    

    })();
  });