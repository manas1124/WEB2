window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component
function test() {
  console.log("test2");
}

async function getAllKhaoSat() {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "getAllKhaoSat"},
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

async function getAllNhomKs() {
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "POST",
      data: { func: "getAllNhomKs"},
      dataType: "json",
    });
    return response;
  } catch (error) {
    console.log("loi fetchdata allnhomks ")
    return null;
  }
}
async function getKhaoSatById() {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: JSON.stringify({ func: "getKhaoSatById", data: { ks_id: 1 } }),
    });
    // response is json type
    return { data: response , error: null};  // Directly return the JSON response
  } catch (error) {
    console.log("loi fetchdata getKhaoSatById");
    return null;
  }
}

$(function () {

  $(".main-content").on("click",".action-item", function (e) {
      e.preventDefault();
      let action = $(this).data("act");
      console.log(action)
      // $(".main-content").load(`day la trang ${action}`)
  });


  (async () => {
    let ksList  = await getAllKhaoSat();
    // ksList = JSON.parse(ksList)
    if (ksList != null) {
      // console.log(ksList)
      
      ksList.map((item) => {
        $("#ks-list").append(`
          <tr>
              <td>${item.ten_ks}</td>
              <td>${item.ngay_bat_dau}</td>
              <td>${item.ngay_ket_thuc}</td>
              <td class="text-center">
              ${
                item.su_dung == 1
                  ? '<span class="badge badge-soft badge-success ">Đang thực hiện</span>'
                  : '<span class="badge badge-soft badge-error ">Kết thúc</span>'
              }
              </td>
              <td>
                <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--pencil] size-5"></span></button>
                <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--trash] size-5"></span></button>
                <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--dots-vertical] size-5"></span></button>
              </td>
          </tr>
  
        `);
      });
      
    }
    
    // let nhomKsList = await getAllNhomKs();
    // if (nhomKsList != null) {
    //   console.log(nhomKsList)
    //   nhomKsList.map( (nhom) =>{
    //     $("#select-nhom-ks").append(`
    //       <option value="aries"></option>
    //       `)
    //   } )
      
    // }


  })();
});

