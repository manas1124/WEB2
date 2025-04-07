async function getNhomKs() {
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "GET",
      data: { func: "getAllNhomKs" },
      dataType: "json",
    });
    console.log("fect", response);
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function getAllNganh() {
  try {
    const response = await $.ajax({
      url: "./controller/nganhController.php",
      type: "GET",
      data: { func: "getAllNganh" },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function getAllChuKi() {
  try {
    const response = await $.ajax({
      url: "./controller/chuKiController.php",
      type: "GET",
      data: { func: "getAllChuKi" },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function getAllTraLoi() {
  try {
    const response = await $.ajax({
      url: "./controller/loaiTraLoiController.php",
      type: "GET",
      data: { func: "getAllTraLoi" },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    console.log("fect", response);
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function createKhaoSat(data) {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "createKhaoSat", data: JSON.stringify(data) },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    console.log("fect", response);
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi  tao khao sat");
    return false;
  }
}
//return -1:not found || ctdt id
async function checkExistCtdt(nganh_id, chu_ki_id, is_ctdt_daura) {
  console.log("check exit input",nganh_id, chu_ki_id, is_ctdt_daura)
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: {
        func: "checkExistCtdt",
        data: JSON.stringify({
          nganh_id: nganh_id,
          chu_ki_id: chu_ki_id,
          is_ctdt_daura: is_ctdt_daura,
        }),
      },
    });
    return response; // return id cdtd tim duoc
  } catch (e) {
    console.log("loi fetchdata loi kiem tra ctdt",e);
    return -1;
  }
}
async function getChiTietKsById(id) {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "getChiTietKsById", id: id},
      dataType: "json",
    });
    console.log("fect",response)
    return response;
  } catch (e) {
    console.log(e)
    console.log("loi fetchdata getAllKhaoSat")
    return null;
  }
}

$(function () {
  window.HSStaticMethods.autoInit();
  (async () => {
    const defaultData = await getChiTietKsById(1);
    const nhomKsList = await getNhomKs();
    const nganhList = await getAllNganh();
    const chuKiList = await getAllChuKi();
    const answerTypeList = await getAllTraLoi();

    if (nhomKsList != null) {
      nhomKsList.map((item) => {
        $("#list-nhomks-option").append(
          `<div class="nhomks-option p-2 hover:bg-gray-200 cursor-pointer" 
          data-value='${item.nks_id}'>${item.ten_nks}</div>
          `
        );
      });
    }
    if (nganhList != null) {
      nganhList.map((item) => {
        if (item.nganh_id == defaultData.nganh_id) {
          $("#select-nganh").append(
            `<option value='${item.nganh_id}' selected="selected">${item.ten_nganh}</option>`
          );
        }
        $("#select-nganh").append(
          `<option value='${item.nganh_id}'>${item.ten_nganh}</option>`
        );
      });
    }
    if (chuKiList != null) {
      chuKiList.map((item) => {
        if (item.ck_id == defaultData.ck_id) {
          $("#select-chu-ki").append(
           `<option selected="selected" value='${item.ck_id}'>${item.ten_ck}</option>`
          );
        }
        $("#select-chu-ki").append(
          `<option value='${item.ck_id}'>${item.ten_ck}</option>`
        );
      });
    }
    if (answerTypeList != null) {
      answerTypeList.map((item) => {
        if ( defaultData.ltl_id == item.ltl_id) {
          $("#select-loai-tra-loi").append(
            `<option selected="selected" value='${item.ltl_id}'>${item.thang_diem}</option>`
          );
        }
        $("#select-loai-tra-loi").append(
          `<option value='${item.ltl_id}'>${item.thang_diem}</option>`
        );
      });
    }
    $("#select-ks-type").val(defaultData.la_ctdt);
    $("#ten-ks").val(defaultData.ten_ks);
    $("#begin").val(defaultData.ngay_bat_dau);
    $("#end").val(defaultData.ngay_ket_thuc);
    $("#selected-nhom-ks").val(defaultData.nks_id);
    // xu ly select search nhom khao sat
    const selectNhomKsBox = document.getElementById("select-nhomks-box");
    const nhomKsDropdown = document.getElementById("nhomKsDropdown");
    const nhomKsInput = document.getElementById("nhomKsInput");
    const selectedNhomKs = document.getElementById("selected-nhom-ks");
    const listNhomKsOption = document.getElementById("list-nhomks-option"); // Get the container
    
    // Default Value Setup
    const defaultNhomKsText = "Your Default Group Name"; // Replace with the text you want
    const defaultNhomKsValue = "your-default-value"; // Replace with the corresponding data-value
    
    // Create a default option element
    const defaultOption = document.createElement("div");
    defaultOption.classList.add("nhomks-option", "p-2", "hover:bg-gray-200", "cursor-pointer"); // Add styling
    defaultOption.textContent = defaultNhomKsText;
    defaultOption.dataset.value = defaultNhomKsValue;
    
    // Add it to the list container
    listNhomKsOption.appendChild(defaultOption);
    
    // Set the displayed text and value
    selectedNhomKs.textContent = defaultNhomKsText;
    selectedNhomKs.value = defaultNhomKsValue;
    
    // Add event listeners after the default is set
    const nhomOptions = document.querySelectorAll(".nhomks-option"); // Re-query after adding default
    
    selectNhomKsBox.addEventListener("click", () => {
      nhomKsDropdown.classList.toggle("hidden");
      nhomKsInput.value = ""; // Clear search input when nhomKsDropdown opens
      filterOptions("");
    });
    
    nhomOptions.forEach((option) => {
      option.addEventListener("click", () => {
        selectedNhomKs.textContent = option.textContent;
        selectedNhomKs.value = option.dataset.value;
        nhomKsDropdown.classList.toggle("hidden");
      });
    });
    
    nhomKsInput.addEventListener("input", (e) => {
      filterOptions(e.target.value);
    });
    
    function filterOptions(query) {
      nhomOptions.forEach((option) => {
        if (option.textContent.toLowerCase().includes(query.toLowerCase())) {
          option.style.display = "block";
        } else {
          option.style.display = "none";
        }
      });
    }
    
    // Close nhomKsDropdown when clicking outside
    document.addEventListener("click", (e) => {
      if (
        !selectNhomKsBox.contains(e.target) &&
        !nhomKsDropdown.contains(e.target)
      ) {
        nhomKsDropdown.classList.add("hidden");
      }
    });
    // xu li cai gia tri mac dinh
    

    // xua li tao bai noi dung khao sat
    const survey = document.getElementById("survey-container");
    const btnAddSection = document.getElementById("btn-add-question");
    const submitSurveyButton = document.getElementById("btn-save-ks");

    btnAddSection.addEventListener("click", () => {
      const section = document.createElement("div");
      section.classList.add("mb-4", "border", "border-gray-300", "p-8");
      section.classList.add("section");

      const sectionTitle = document.createElement("h3");
      sectionTitle.textContent = "Tên mục:";
      section.appendChild(sectionTitle);

      const sectionNameInput = document.createElement("input");
      sectionNameInput.placeholder = "Nhập tên mục";
      sectionNameInput.classList.add("input", "mb-4");
      section.appendChild(sectionNameInput);

      // sectionNameInput.addEventListener("input", () => {
      //   sectionTitle.textContent =
      //     sectionNameInput.value || `Section ${survey.children.length + 1}`;
      // });

      const questionContainer = document.createElement("div");
      questionContainer.classList.add("question-container");
      section.appendChild(questionContainer);

      const btnAddQuestion = document.createElement("button");
      btnAddQuestion.textContent = "Thêm câu hỏi";
      btnAddQuestion.classList.add("btn", "btn-primary", "btn-sm");
      btnAddQuestion.addEventListener("click", () => {
        const question = document.createElement("div");
        question.classList.add(
          "question-item",
          "flex-row",
          "flex",
          "items-center",
          "gap-4",
          "mb-4"
        );
        question.innerHTML = `
                  <label class="label-text text-nowrap">Câu hỏi:</label>
                  <input type="text" class="questionInput input w-s"/>
                  <button class="deleteQuestion btn btn-square btn-outline btn-error">
                  <span class="icon-[tabler--x]"></span>
                  </button>
              `;
        questionContainer.appendChild(question);

        const deleteQuestionButton = question.querySelector(".deleteQuestion");
        deleteQuestionButton.addEventListener("click", () => {
          question.remove();
        });
      });
      section.appendChild(btnAddQuestion);

      const deleteSectionButton = document.createElement("button");
      deleteSectionButton.textContent = "Xóa mục";
      deleteSectionButton.classList.add(
        "btn",
        "btn-error",
        "ml-[10px]",
        "btn-sm"
      );
      deleteSectionButton.addEventListener("click", () => {
        section.remove();
      });
      section.appendChild(deleteSectionButton);

      survey.appendChild(section);
    });

    //xu ly submit
    submitSurveyButton.addEventListener("click", () => {
      const surveyContent = [];
      const sections = survey.querySelectorAll(".section");

      const tenKhaoSat = $("#ten-ks").val();
      const idNhomKs = selectedNhomKs.value;
      const dateStart = $("#begin").val();
      const dateEnd = $("#end").val();
      const loaiTraLoi = $("#select-loai-tra-loi").val();
      const nganh = $("#select-nganh").val();
      const chuKi = $("#select-chu-ki").val();
      const loaiKs = $("#select-ks-type").val();

      sections.forEach((section) => {
        const sectionName = section.querySelector("input").value;
        const questions = [];
        const questionElements = section.querySelectorAll(".question-item");

        questionElements.forEach((questionElement) => {
          const questionInput =
            questionElement.querySelector(".questionInput").value;
          questions.push(questionInput);
        });

        surveyContent.push({
          sectionName: sectionName,
          questions: questions,
        });
      });

      const createSurveyData = {
        "ten-ks": tenKhaoSat,
        "nhomks-id": idNhomKs,
        "date-start": dateStart,
        "date-end": dateEnd,
        "loai-tra-loi": loaiTraLoi,
        content: surveyContent,
      };

      let isValideData = () => {
        if (tenKhaoSat == "") {
          alert("Vui lòng nhập tên bài khảo sát");
          return false;
        } else if (idNhomKs == "-1") {
          alert("Vui lòng chọn nhóm bài khảo sát");
          return false;
        } else if (dateStart == "") {
          alert("Vui lòng chọn ngày bắt đầu");
          return false;
        } else if (dateEnd == "") {
          alert("Vui lòng chọn ngày kết thúc");
          return false;
        } else if (loaiTraLoi == "-1") {
          alert("Vui lòng chọn loại trả lời");
          return false;
        } else if (nganh == "-1") {
          alert("Vui lòng chọn ngành");
          return false;
        } else if (chuKi == "-1") {
          alert("Vui lòng chọn chu kì");
          return false;
        }
        return true;
      };
      console.log(createSurveyData);
     
      if (isValideData()) {
        checkExistCtdt(nganh, chuKi, loaiKs).then((isExistCtdt) => {
          if (isExistCtdt == -1) {
            alert("không có chương trình đào đạo thuộc ngành, chu kì này");
            return;
          }
          createSurveyData["ctdt-id"] = isExistCtdt;
          createKhaoSat(createSurveyData).then((response) => {
            if( response) {
              alert("tạo ks thành công")
            } else {
              alert("tạo ks thất bại")
            }
          });
        });
      }
    });
  })();
});
