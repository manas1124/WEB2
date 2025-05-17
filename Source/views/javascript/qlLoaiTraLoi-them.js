window.HSStaticMethods.autoInit();

function isValidate(data) {
  console.log(data["mo-ta"]);
  console.log(data["thang-diem"]);
  console.log(data["chi-tiet"]);
  let flag = true;
  let message = '';
  if (data["mo-ta"] == null || data["mo-ta"] == '') {
    message = 'Mô tả không được để trống!';
    flag = false;
  }
  else if (data["thang-diem"] < 2) {
    message = 'Phải có ít nhất 2 sự lựa chọn!';
    flag = false;

  }
  else {
    data["chi-tiet"].forEach(element => {
      if (element == null || element == '') {
        message = 'Mô tả lựa chọn không được để trống!';
        flag = false;
        return;
      }
    });
  }
  if (flag == false) {
    Swal.fire({
      icon: 'warning',
      title: 'Thông báo',
      text: message,
      confirmButtonText: "Đã hiểu",
      confirmButtonColor: '#3085d6'
    })
  }
  return flag;
}

function getdata() {
  const moTa = document.getElementById("mo-ta").value;
  const sections = document.querySelectorAll("#ltl-container .section");
  const trangDiem = sections.length;
  const chiTiet = [];
  sections.forEach(section => {
    let inputMota = section.querySelector('.input').value;
    chiTiet.push(inputMota);
  });
  return {
    'mo-ta': moTa,
    'thang-diem': trangDiem,
    'chi-tiet': chiTiet
  };
}

function create() {
  const data = getdata();
  if (isValidate(data)) {
    const formData = new FormData();
    formData.append('func', 'create');
    formData.append("mo-ta", data["mo-ta"]);
    formData.append("thang-diem", data["thang-diem"]);
    formData.append("chi-tiet", JSON.stringify(data["chi-tiet"]));
    $.ajax({
      url: "./controller/loaiTraLoiController.php",
      type: "POST",
      dataType: "json",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.status) {
          Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: response.message,
            confirmButtonText: "Đã hiểu",
            confirmButtonColor: '#3085d6'
          }).then((result) => {
            if (result.isConfirmed) {
              history.back();
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: response.message,
            confirmButtonText: "Đã hiểu",
            confirmButtonColor: '#3085d6'
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:");
        console.error("Status:", status);
        console.error("Error:", error);
        console.error("Response Text:", xhr.responseText);
      }
    });
  }
}

$(function () {
  const ltlContainer = document.getElementById("ltl-container");
  const btnAddSection = document.getElementById("btn-add-section");

  function updateSectionTitles() {
    const sections = ltlContainer.querySelectorAll(".section");
    sections.forEach((section, index) => {
      const title = section.querySelector("h3");
      title.textContent = `Lựa chọn ${index + 1}:`;
    });
  }

  btnAddSection.addEventListener("click", () => {
    const sectionElements = document.getElementsByClassName("section");
    if (sectionElements.length >= 10) {
      console.log(sectionElements.length);
      Swal.fire({
        title: 'Thông báo',
        text: 'Bạn chỉ có thể thêm tối đa 10 lựa chọn',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Đã hiểu'
      });
      return;
    }
    const section = document.createElement("div");
    section.classList.add("mb-4", "border", "border-gray-300", "p-4", "section");

    const titleContainer = document.createElement("div");
    const sectionTitle = document.createElement("h3");
    titleContainer.appendChild(sectionTitle);
    section.appendChild(titleContainer);

    const inputContainer = document.createElement("div");
    const sectionInput = document.createElement("input");
    sectionInput.placeholder = "Nhập mô tả cho lựa chọn";
    sectionInput.classList.add("input", "my-4", "block");
    inputContainer.appendChild(sectionInput);
    section.appendChild(inputContainer);

    const buttonContainer = document.createElement("div");
    buttonContainer.classList.add("flex", "justify-end");
    const sectionButtonDelete = document.createElement("button");
    const iconDelete = document.createElement('span');
    iconDelete.classList.add("icon-[material-symbols--delete-outline]");
    sectionButtonDelete.appendChild(iconDelete);
    sectionButtonDelete.classList.add("btn", "btn-error");
    sectionButtonDelete.addEventListener("click", () => {
      section.remove();
      updateSectionTitles();
    });
    buttonContainer.appendChild(sectionButtonDelete);
    section.appendChild(buttonContainer);

    ltlContainer.appendChild(section);
    updateSectionTitles();
  });

  // Cho phép kéo thả các mục
  Sortable.create(ltlContainer, {
    animation: 150,
    onEnd: function () {
      updateSectionTitles();
    }
  });

  $("#btn-create").on("click", function () {
    create();
  });
});