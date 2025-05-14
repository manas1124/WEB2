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
  
  $(function () {
    $(document).on("click", "#btn-create", async function (e) {
      e.preventDefault();
      const ten_nks = $("#ten-nhomks").val().trim();
  
      if (ten_nks === "") {
        alert("Vui lòng nhập tên nhóm khảo sát!");
        return;
      }
  
      const result = await addNhomks(ten_nks);
      if (result.success) {
        alert("Thêm thành công!");
        location.reload(); 
      } else {
        alert(result.message);
      }
    });
  });