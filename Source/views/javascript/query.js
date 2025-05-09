async function getCurrentLoginAccount() {
  try {
    const response = await $.ajax({
      url: "./controller/AuthController.php",
      type: "POST",
      dataType: "json",
      data: { func: "getCurrentLoginUser" },
    });
    if (response.status == "error") {
      console.log(response.message);
      return null;
    }
    return response.userInfor;
  } catch (error) {
    console.error(error);
    return null;
  }
}
async function getUserById(id) {
  try {
    const response = await $.ajax({
      url: "./controller/UserController.php",
      type: "POST",
      data: { func: "getUserById", id: id },
      dataType: "json",
    });
    console.log(" Phản hồi getUserById:", response.data);
    return response.data;
  } catch (error) {
    console.log("Lỗi khi lấy dữ liệu người dùng", error);
    return null;
  }
}
